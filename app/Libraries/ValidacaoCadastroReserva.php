<?php

namespace App\Libraries;

use App\Entities\DatasExtraordinariasEntity;
use App\Entities\OficinaTematicaEntity;
use App\Entities\ParticipanteEntity;
use App\Entities\ReservaEntity;
use App\Entities\RecursoTrabalhoEntity;
use App\Models\AtividadeLivreModel;
use App\Models\AtividadeLivreRecursoModel;
use App\Models\ConfiguracaoModel;
use App\Models\DatasExtraordinariasModel;
use App\Models\HorarioFuncionamentoModel;
use App\Models\OficinaTematicaModel;
use App\Models\OficinaTematicaReservaModel;
use App\Models\ParticipanteModel;
use App\Models\RecursoOficinaModel;
use App\Models\RecursoTrabalhoModel;
use App\Models\ReservaModel;
use App\Models\ReservaParticipanteModel;
use DateInterval;
use DateTime;

class ValidacaoCadastroReserva
{
    
    public function validarDadosInputCadastrar(object $data)
    {
        // Regra de integridade: payload precisa ser objeto com ao menos um intervalo válido
        if (!is_object($data) || !is_array($data->interval ?? null) || empty($data->interval)) {
            return $this->erro('Requisição inválida!');
        }

        // Regra de elegibilidade: participante deve existir e estar ativo
        $participante = (new ParticipanteModel())->find($data->participantId ?? null);
        if (!$participante instanceof ParticipanteEntity) {
            return $this->erro('Participante não encontrado.');
        }
        if ((int) ($participante->suspenso ?? ParticipanteEntity::SUSPENSO_NAO) === ParticipanteEntity::SUSPENSO_SIM) {
            return $this->erro('Participante suspenso não pode realizar reservas.');
        }

        // Regra de configuração: sistema precisa da lotação cadastrada
        $configuracao = (new ConfiguracaoModel())->find(1);
        if ($configuracao === null) {
            return $this->erro('Configuração não encontrada.');
        }

        // Regra de capacidade: quantidade de pessoas deve respeitar os limites da configuração
        if (!is_int($data->people ?? null) || $data->people < 1 || $data->people > $configuracao->lotacaoEspaco) {
            return $this->erro('Número de pessoas inválido!');
        }

        // Regra de formato: data da reserva precisa estar no padrão esperado
        $dataReserva = DateTime::createFromFormat('Y-m-d', (string) ($data->date ?? ''));
        if ($dataReserva === false) {
            return $this->erro('Data inválida');
        }

        // Regra temporal: não permite reservas retroativas
        if ($dataReserva->setTime(0, 0, 0) < (new DateTime())->setTime(0, 0, 0)) {
            return $this->erro('Data selecionado deve ser maior que a atual');
        }

        // Regras por intervalo: garante horário válido, duração mínima/máxima e permanência no mesmo dia
        foreach ($data->interval as $r) {
            if (DateTime::createFromFormat('H:i', $r->start ?? '') === false) {
                return $this->erro('Horário inválido');
            }
            if (!is_int($r->duration ?? null) || $r->duration < 30 || $r->duration > 1440) {
                return $this->erro('Intervalo inválido');
            }
            if (DateTime::createFromFormat('Y-m-d H:i', $data->date . ' ' . ($r->start ?? '')) === false) {
                return $this->erro('O valor de data e/ou hora são inválidos');
            }
            $inicioReserva = DateTime::createFromFormat('Y-m-d H:i', $data->date . ' ' . $r->start);
            $fimReserva = clone $inicioReserva;
            $fimReserva->add(new DateInterval('PT' . $r->duration . 'M'));
            if ($inicioReserva->format('Y-m-d') !== $fimReserva->format('Y-m-d')) {
                return $this->erro('Reservas não podem ultrapassar para o outro dia');
            }
        }

        $validacaoConflito = $this->validarConflitosParticipante($data, (int) $participante->id);
        if ($validacaoConflito !== true) {
            return $validacaoConflito;
        }

        // Regra de domínio: tipo de atividade precisa ser reconhecido
        if (!isset($data->activity) || !isset($data->activity->type) || !in_array($data->activity?->type, ['oficina', 'livre'], true)) {
            return $this->erro('Tipo de atividade inválida');
        }

        if ($data->activity->type === 'livre') {
            // Regra de atividade livre: recursos informados precisam existir e descrição é obrigatória
            if (!isset($data->activity->resourceIds) || !is_array($data->activity->resourceIds)) {
                return $this->erro('Tipo de atividade inválida');
            }
            foreach ($data->activity->resourceIds as $rid) {
                if (!(new RecursoTrabalhoModel())->find($rid) instanceof RecursoTrabalhoEntity) {
                    return $this->erro('Recurso inválido');
                }
            }
            if (!isset($data->activity->description) || strlen((string) $data->activity->description) === 0) {
                return $this->erro('Descrição é obrigatória');
            }
        }

        if ($data->activity->type === 'oficina') {
            // Regra de oficina: oficina temática precisa estar cadastrada
            if (!(new OficinaTematicaModel())
                ->where('situacao', 0)
                ->find($data->activity->id ?? null) instanceof OficinaTematicaEntity) {
                return $this->erro('Oficina Temática inválido');
            }
        }

        // Regra escolar: campos de identificação escolar devem existir e serem preenchidos quando aplicável
        if (!isset($data->isClass) || !isset($data->nameSchool) || !isset($data->yearClass)) {
            return $this->erro('Campos colégios ausentes');
        }
        if ($data->isClass === true && ($data->nameSchool === '' || $data->yearClass === '')) {
            return $this->erro('Campos "Nome Escola" e "Ano Turma" são obrigados quando escola');
        }

        // Regra agregada: executa as validações de horário, lotação e recursos
        $validacaoRegra = $this->validarRegras($data, (int) $configuracao->lotacaoEspaco);
        if ($validacaoRegra !== true) {
            return $validacaoRegra;
        }

        return true;
    }

    private function validarConflitosParticipante(object $data, int $participanteId)
    {
        $intervalos = is_array($data->interval ?? null) ? $data->interval : [];
        if (empty($intervalos)) {
            return true;
        }

        $dataReserva = DateTime::createFromFormat('Y-m-d', (string) ($data->date ?? ''));
        if (!$dataReserva instanceof DateTime) {
            return true;
        }

        $novosIntervalos = [];
        foreach ($intervalos as $intervalo) {
            $inicio = DateTime::createFromFormat(
                'Y-m-d H:i',
                $dataReserva->format('Y-m-d') . ' ' . (string) ($intervalo->start ?? '')
            );
            $duracao = (int) ($intervalo->duration ?? 0);
            if (!$inicio instanceof DateTime || $duracao <= 0) {
                continue;
            }

            $fim = clone $inicio;
            $fim->add(new DateInterval('PT' . $duracao . 'M'));

            $inicioMin = $this->toMinutes($inicio->format('H:i'));
            $fimMin = $this->toMinutes($fim->format('H:i'));
            if ($inicioMin === null || $fimMin === null) {
                continue;
            }

            $novosIntervalos[] = ['inicio' => $inicioMin, 'fim' => $fimMin];
        }

        if ($novosIntervalos === []) {
            return true;
        }

        $reservasParticipante = (new ReservaParticipanteModel())
            ->select('Reserva.horaInicio, Reserva.horaFim')
            ->join('Reserva', 'Reserva.id = ReservaParticipante.Reserva_id')
            ->where('ReservaParticipante.Participante_id', $participanteId)
            ->where('Reserva.status', ReservaEntity::STATUS_ATIVO)
            ->where('Reserva.dataReserva', $dataReserva->format('Y-m-d'))
            ->asArray()
            ->findAll();

        foreach ($reservasParticipante as $reservaAtual) {
            $inicioExistente = $this->toMinutes($reservaAtual['horaInicio'] ?? null);
            $fimExistente = $this->toMinutes($reservaAtual['horaFim'] ?? null);
            if ($inicioExistente === null || $fimExistente === null) {
                continue;
            }

            foreach ($novosIntervalos as $novo) {
                if ($this->overlaps($novo['inicio'], $novo['fim'], $inicioExistente, $fimExistente)) {
                    return $this->erro(sprintf(
                        'Participante já possui reserva entre %s e %s.',
                        $reservaAtual['horaInicio'],
                        $reservaAtual['horaFim']
                    ));
                }
            }
        }

        return true;
    }

    private function validarRegras(object $data, int $lotacaoMaxima)
    {
        $intervalos = $data->interval ?? [];
        // Regra: ao menos um intervalo precisa ser informado
        if (!is_array($intervalos) || empty($intervalos)) {
            return $this->erro('Intervalos da reserva não informados.');
        }

        // Regra: lotação máxima deve estar configurada
        if ($lotacaoMaxima <= 0) {
            return $this->erro('Configuração de lotação não encontrada.');
        }

        // Regra de formato: data precisa ser válida para análise de funcionamento
        $dataReserva = DateTime::createFromFormat('Y-m-d', (string) $data->date);
        if ($dataReserva === false) {
            return $this->erro('Data da reserva inválida.');
        }

        // Regra de calendário: combina horários regulares e aberturas extras para formar janelas válidas
        $intervalosFuncionamento = $this->obterIntervalosFuncionamento($dataReserva);
        $intervalosFuncionamento = array_merge(
            $intervalosFuncionamento,
            $this->obterAberturasExtraordinarias($data->date)
        );

        $intervalosFechados = $this->obterFechamentosExtraordinarios($data->date);

        // Regra: não permite agendar em dia sem horário disponível
        if (empty($intervalosFuncionamento)) {
            return $this->erro('Não há horário de funcionamento disponível para a data selecionada.');
        }

        // Regra de concorrência: carrega reservas existentes e seus recursos
        $reservasExistentes = $this->obterReservasDoDia($data->date);
        $recursosPorReserva = $this->mapearRecursosPorReserva($reservasExistentes['ids']);

        // Regra de recursos exclusivos: valida capacidade e disponibilidade
        $recursosExclusivos = $this->obterRecursosExclusivos($data);
        if (isset($recursosExclusivos['erro']) && $recursosExclusivos['erro'] === true) {
            return $recursosExclusivos;
        }
        $recursosExclusivosIds = array_keys($recursosExclusivos);

        $pessoasSolicitadas = (int) $data->people;
        $intervalosPendentes = [];

        foreach ($intervalos as $intervalo) {
            $inicioMin = $this->toMinutes((string) $intervalo->start);
            $fimMin = $inicioMin !== null ? $inicioMin + (int) $intervalo->duration : null;
            if ($inicioMin === null || $fimMin === null) {
                return $this->erro('Intervalo inválido.');
            }

            // Regra: intervalo deve estar contido no horário de funcionamento
            if (!$this->intervaloDentroDeFuncionamento($inicioMin, $fimMin, $intervalosFuncionamento)) {
                return $this->erro(sprintf(
                    'Horário %s às %s está fora do horário de funcionamento.',
                    (string) $intervalo->start,
                    $this->formatMinutes($fimMin)
                ));
            }

            // Regra: bloqueia horários em janelas de fechamento extraordinário
            foreach ($intervalosFechados as $janelaFechada) {
                if ($this->overlaps($inicioMin, $fimMin, $janelaFechada['inicio'], $janelaFechada['fim'])) {
                    return $this->erro(sprintf(
                        'Horário indisponível entre %s e %s devido a fechamento extraordinário.',
                        $this->formatMinutes($janelaFechada['inicio']),
                        $this->formatMinutes($janelaFechada['fim'])
                    ));
                }
            }

            $ocupacaoAtual = 0;
            foreach ($reservasExistentes['dados'] as $reserva) {
                if ($this->overlaps($inicioMin, $fimMin, $reserva['inicio'], $reserva['fim'])) {
                    $ocupacaoAtual += $reserva['pessoas'];
                }
            }
            foreach ($intervalosPendentes as $pendente) {
                if ($this->overlaps($inicioMin, $fimMin, $pendente['inicio'], $pendente['fim'])) {
                    $ocupacaoAtual += $pendente['pessoas'];
                }
            }

            $totalComNovo = $ocupacaoAtual + $pessoasSolicitadas;
            // Regra: somatório de pessoas não pode ultrapassar a lotação do espaço
            if ($totalComNovo > $lotacaoMaxima) {
                return $this->erro(sprintf(
                    'Lotação excedida entre %s e %s (%d/%d pessoas).',
                    (string) $intervalo->start,
                    $this->formatMinutes($fimMin),
                    $totalComNovo,
                    $lotacaoMaxima
                ));
            }

            if (!empty($recursosExclusivos)) {
                foreach ($recursosExclusivos as $recursoId => $dadosRecurso) {
                    $utilizacao = 0;
                    foreach ($reservasExistentes['dados'] as $reserva) {
                        $recursosReserva = $recursosPorReserva[$reserva['id']] ?? [];
                        if (!in_array($recursoId, $recursosReserva, true)) {
                            continue;
                        }
                        if ($this->overlaps($inicioMin, $fimMin, $reserva['inicio'], $reserva['fim'])) {
                            $utilizacao++;
                        }
                    }
                    foreach ($intervalosPendentes as $pendente) {
                        if (!in_array($recursoId, $pendente['recursos'], true)) {
                            continue;
                        }
                        if ($this->overlaps($inicioMin, $fimMin, $pendente['inicio'], $pendente['fim'])) {
                            $utilizacao++;
                        }
                    }

                    $totalUtilizacao = $utilizacao + 1;
                    // Regra: uso simultâneo de recursos exclusivos respeita o estoque
                    if ($totalUtilizacao > $dadosRecurso['capacidade']) {
                        $utilizacaoExibida = $utilizacao;
                        return $this->erro(sprintf(
                            'Recurso exclusivo "%s" indisponível entre %s e %s (%d/%d em uso).',
                            $dadosRecurso['nome'],
                            (string) $intervalo->start,
                            $this->formatMinutes($fimMin),
                            $utilizacaoExibida,
                            $dadosRecurso['capacidade']
                        ));
                    }
                }
            }

            // Regra: intervalos aprovados entram na conta para detectar conflitos subsequentes
            $intervalosPendentes[] = [
                'inicio' => $inicioMin,
                'fim' => $fimMin,
                'pessoas' => $pessoasSolicitadas,
                'recursos' => $recursosExclusivosIds,
            ];
        }

        return true;
    }

    private function obterIntervalosFuncionamento(DateTime $dataReserva): array
    {
        $indicesDia = array_unique([
            (int) $dataReserva->format('N'),
            (int) $dataReserva->format('w'),
        ]);
        $indicesDia = array_values(array_filter($indicesDia, static fn ($valor): bool => $valor >= 0));

        if (empty($indicesDia)) {
            return [];
        }

        $horarios = (new HorarioFuncionamentoModel())
            ->whereIn('diaSemana', $indicesDia)
            ->findAll();

        $intervalos = [];
        foreach ($horarios as $horario) {
            $inicio = $this->toMinutes((string) $horario->horaInicio);
            $fim = $this->toMinutes((string) $horario->horaFinal);
            if ($inicio === null || $fim === null || $inicio >= $fim) {
                continue;
            }
            $intervalos[] = ['inicio' => $inicio, 'fim' => $fim];
        }

        return $intervalos;
    }

    private function obterAberturasExtraordinarias(string $data): array
    {
        $registros = (new DatasExtraordinariasModel())
            ->where('data', $data)
            ->where('tipo', DatasExtraordinariasEntity::TIPO_ABERTO)
            ->findAll();

        $intervalos = [];
        foreach ($registros as $extra) {
            $inicio = $this->toMinutes((string) $extra->horaInicio);
            $fim = $this->toMinutes((string) $extra->horaFim);
            if ($inicio === null || $fim === null || $inicio >= $fim) {
                continue;
            }
            $intervalos[] = ['inicio' => $inicio, 'fim' => $fim];
        }

        return $intervalos;
    }

    private function obterFechamentosExtraordinarios(string $data): array
    {
        $registros = (new DatasExtraordinariasModel())
            ->where('data', $data)
            ->where('tipo', DatasExtraordinariasEntity::TIPO_FECHADO)
            ->findAll();

        $intervalos = [];
        foreach ($registros as $extra) {
            $inicio = $this->toMinutes((string) $extra->horaInicio);
            $fim = $this->toMinutes((string) $extra->horaFim);
            if ($inicio === null || $fim === null || $inicio >= $fim) {
                continue;
            }
            $intervalos[] = ['inicio' => $inicio, 'fim' => $fim];
        }

        return $intervalos;
    }

    private function obterReservasDoDia(string $data): array
    {
        $reservas = (new ReservaModel())
            ->select('id, horaInicio, horaFim, numeroConvidados')
            ->where('dataReserva', $data)
            ->where('status', ReservaEntity::STATUS_ATIVO)
            ->findAll();

        $dados = [];
        $ids = [];
        foreach ($reservas as $reserva) {
            $inicio = $this->toMinutes((string) $reserva->horaInicio);
            $fim = $this->toMinutes((string) $reserva->horaFim);
            if ($inicio === null || $fim === null) {
                continue;
            }
            $dados[] = [
                'id' => (int) $reserva->id,
                'inicio' => $inicio,
                'fim' => $fim,
                'pessoas' => (int) $reserva->numeroConvidados,
            ];
            $ids[] = (int) $reserva->id;
        }

        return ['dados' => $dados, 'ids' => array_values(array_unique($ids))];
    }

    private function mapearRecursosPorReserva(array $reservaIds): array
    {
        $resultado = [];
        if (empty($reservaIds)) {
            return $resultado;
        }

        $reservaOficinas = [];
        $oficinaIds = [];
        foreach ((new OficinaTematicaReservaModel())
            ->select('Reserva_id, OficinaTematica_id')
            ->whereIn('Reserva_id', $reservaIds)
            ->findAll() as $linha) {
            $reservaId = (int) $linha->Reserva_id;
            $oficinaId = (int) $linha->OficinaTematica_id;
            $reservaOficinas[$reservaId][] = $oficinaId;
            $oficinaIds[$oficinaId] = true;
        }

        $oficinaRecursos = [];
        if (!empty($oficinaIds)) {
            foreach ((new RecursoOficinaModel())
                ->select('OficinaTematica_id, RecursoTrabalho_id')
                ->whereIn('OficinaTematica_id', array_keys($oficinaIds))
                ->findAll() as $linha) {
                $oficinaRecursos[(int) $linha->OficinaTematica_id][] = (int) $linha->RecursoTrabalho_id;
            }
        }

        foreach ($reservaOficinas as $reservaId => $listaOficinas) {
            foreach ($listaOficinas as $oficinaId) {
                foreach ($oficinaRecursos[$oficinaId] ?? [] as $recursoId) {
                    $resultado[$reservaId][$recursoId] = true;
                }
            }
        }

        $reservaAtividades = [];
        $atividadeIds = [];
        foreach ((new AtividadeLivreModel())
            ->select('id, Reserva_id')
            ->whereIn('Reserva_id', $reservaIds)
            ->findAll() as $atividade) {
            $atividadeId = (int) $atividade->id;
            $reservaId = (int) $atividade->Reserva_id;
            $reservaAtividades[$reservaId][] = $atividadeId;
            $atividadeIds[$atividadeId] = true;
        }

        if (!empty($atividadeIds)) {
            $atividadeRecursos = [];
            foreach ((new AtividadeLivreRecursoModel())
                ->select('AtividadeLivre_id, RecursoTrabalho_id')
                ->whereIn('AtividadeLivre_id', array_keys($atividadeIds))
                ->findAll() as $linha) {
                $atividadeRecursos[(int) $linha->AtividadeLivre_id][] = (int) $linha->RecursoTrabalho_id;
            }

            foreach ($reservaAtividades as $reservaId => $listaAtividades) {
                foreach ($listaAtividades as $atividadeId) {
                    foreach ($atividadeRecursos[$atividadeId] ?? [] as $recursoId) {
                        $resultado[$reservaId][$recursoId] = true;
                    }
                }
            }
        }

        foreach ($resultado as $reservaId => $mapa) {
            $resultado[$reservaId] = array_keys($mapa);
        }

        return $resultado;
    }

    private function obterRecursosExclusivos(object $data)
    {
        // Regra: identifica recursos exclusivos vinculados à atividade solicitada
        $recursosSolicitados = [];
        if (($data->activity->type ?? '') === 'livre') {
            $recursosSolicitados = array_map('intval', $data->activity->resourceIds ?? []);
        } elseif (($data->activity->type ?? '') === 'oficina') {
            $oficinaId = (int) ($data->activity->id ?? 0);
            if ($oficinaId > 0) {
                $recursosSolicitados = (new RecursoOficinaModel())
                    ->select('RecursoTrabalho_id')
                    ->where('OficinaTematica_id', $oficinaId)
                    ->findColumn('RecursoTrabalho_id') ?? [];
                $recursosSolicitados = array_map('intval', $recursosSolicitados);
            }
        }

        $recursosSolicitados = array_values(array_unique(array_filter($recursosSolicitados)));
        if (empty($recursosSolicitados)) {
            return [];
        }

        $detalhes = (new RecursoTrabalhoModel())
            ->select('id, nome, usoExclusivo, quantidadeDisponivel')
            ->whereIn('id', $recursosSolicitados)
            ->findAll();

        $exclusivos = [];
        foreach ($detalhes as $recurso) {
            if ((int) $recurso->usoExclusivo !== 1) {
                continue;
            }
            $capacidade = max(0, (int) $recurso->quantidadeDisponivel);
            // Regra: recursos exclusivos precisam ter unidades disponíveis para reserva
            if ($capacidade <= 0) {
                return $this->erro('Recurso exclusivo "' . $recurso->nome . '" sem unidades disponíveis.');
            }
            $exclusivos[(int) $recurso->id] = [
                'nome' => $recurso->nome,
                'capacidade' => $capacidade,
            ];
        }

        return $exclusivos;
    }

    private function intervaloDentroDeFuncionamento(int $inicio, int $fim, array $janelas): bool
    {
        foreach ($janelas as $janela) {
            if ($inicio >= $janela['inicio'] && $fim <= $janela['fim']) {
                return true;
            }
        }

        return false;
    }

    private function toMinutes(string $time): ?int
    {
        $parts = explode(':', substr($time, 0, 5));
        if (count($parts) < 2) {
            return null;
        }
        return ((int) $parts[0]) * 60 + (int) $parts[1];
    }

    private function formatMinutes(int $minutes): string
    {
        $hours = intdiv($minutes, 60);
        $mins = $minutes % 60;
        return sprintf('%02d:%02d', $hours, $mins);
    }

    private function overlaps(int $startA, int $endA, int $startB, int $endB): bool
    {
        return $startA < $endB && $startB < $endA;
    }

    private function erro(string $mensagem)
    {
        return ['erro' => true, 'msg' => $mensagem];
    }
}
