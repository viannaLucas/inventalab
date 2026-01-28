<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReservaModel;
use App\Entities\ReservaEntity;
use App\Models\AtividadeLivreModel;
use App\Entities\AtividadeLivreEntity;
use App\Entities\AtividadeLivreRecursoEntity;
use App\Entities\ConfiguracaoEntity;
use App\Entities\DatasExtraordinariasEntity;
use App\Models\EventoReservaModel;
use App\Entities\EventoReservaEntity;
use App\Entities\OficinaTematicaEntity;
use App\Models\OficinaTematicaReservaModel;
use App\Entities\OficinaTematicaReservaEntity;
use App\Entities\ParticipanteEntity;
use App\Entities\RecursoTrabalhoEntity;
use App\Models\ReservaParticipanteModel;
use App\Entities\ReservaParticipanteEntity;
use App\Libraries\ValidacaoBR;
use App\Libraries\ValidacaoCadastroReserva;
use App\Models\AtividadeLivreRecursoModel;
use App\Models\CobrancaModel;
use App\Models\CobrancaProdutoModel;
use App\Models\CobrancaServicoModel;
use App\Models\ConfiguracaoModel;
use App\Models\DatasExtraordinariasModel;
use App\Models\HorarioFuncionamentoModel;
use App\Models\OficinaTematicaModel;
use App\Models\ProdutoModel;
use App\Models\RecursoTrabalhoModel;
use App\Models\ReservaCobrancaModel;
use App\Models\ServicoModel;
use CodeIgniter\HTTP\ResponseInterface;
use DateInterval;
use DateTime;
use stdClass;

class Reserva extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        $data['vOficinaTematica'] = (new OficinaTematicaModel())
            ->where('situacao', 0)->findAll();
        $data['vHorarioFuncionamento'] = (new HorarioFuncionamentoModel())
            ->orderBy('diaSemana ASC, horaInicio ASC')->findAll();
        $data['vRecursoTrabalho'] = [];
        $data['configuracao'] = (new ConfiguracaoModel())->find(1);
        $data['vDatasFechado'] = (new DatasExtraordinariasModel())
            ->where('tipo', DatasExtraordinariasEntity::TIPO_FECHADO)
            ->where('data >=  DATE(NOW())')->findAll();
        $data['vDatasAberto'] = (new DatasExtraordinariasModel())
            ->where('tipo', DatasExtraordinariasEntity::TIPO_ABERTO)
            ->where('data >=  DATE(NOW())')->findAll();
        $vReserva = (new ReservaModel())->where('status', ReservaEntity::STATUS_ATIVO)
            ->where('dataReserva >= CURRENT_DATE')->findAll();

        $data['itensReserva'] = $this->formatarReservaView($vReserva);
        
        foreach((new RecursoTrabalhoModel())->findAll() as $rt){
            $ac = new \stdClass();
            $ac->id = $rt->id;
            $ac->exclusive = $rt->usoExclusivo == 1; 
            $ac->name = $rt->nome;
            $ac->quantity = 1;
            $data['vRecursoTrabalho'][] = $ac;
        }
        $data['lAtividades'] = [];
        foreach ($data['vOficinaTematica'] as $i) {
            $rid = [];
            foreach ($i->getListRecursoOficina() as $r) {
                $rid[] = $r->RecursoTrabalho_id;
            }
            $ac = new \stdClass();
            $ac->id = $i->id;
            $ac->description = ''; //$i->descricaoAtividade;
            $ac->name = $i->nome;
            $ac->resourceIds = $rid;
            $data['lAtividades'][] = $ac;
        }
        return view('Painel/Reserva/reserva', $data);
    }

    private function formatarReservaView($vReserva): array
    {
        $itensReserva = [];
        foreach($vReserva as $r){
            $i = new stdClass();
            $i->date = DateTime::createFromFormat('d/m/Y', $r->dataReserva)->format(('Y-m-d'));
            $i->start = $r->horaInicio;
            $i->duration = $r->getDuracaoEmMinutos();
            $i->people = $r->numeroConvidados+1;
            $i->exclusive = $r->tipo == ReservaEntity::TIPO_EXCLUSIVA;
            $i->name = count($r->getListReservaParticipante())>0 ? $r->getListReservaParticipante()[0]?->getParticipante()?->nome : '';
            $vOficinaTematica = $r->getListOficinaTematicaReserva();
            $ac = new stdClass();
            if(!empty($vOficinaTematica)){
                $ac->type = 'oficina';
                $ac->id = $vOficinaTematica[0]->id;
            }
            $vAtividadeLivre = $r->getListAtividadeLivre();
            if(!empty($vAtividadeLivre)){
                $ac->type = 'livre';
                $ac->descricao = 'Atividade Livre';
                $ac->resourceIds = array_map(function($n){ $n->id; }, $vAtividadeLivre[0]->getListAtividadeLivreRecurso());
            }            
            $i->activity = $ac;            
            $itensReserva[] = $i;
        }
        return $itensReserva;
    }

    public function listaReservaJson()
    {
        $vReserva = (new ReservaModel())->where('status', ReservaEntity::STATUS_ATIVO)
            ->where('dataReserva >= CURRENT_DATE')->findAll();
        return $this->response->setJSON($this->formatarReservaView($vReserva));
    }

    public function doCadastrar() {
        $data = $this->request->getJSON();
        $validador = new ValidacaoCadastroReserva();
        $resultadoValidacao = $validador->validarDadosInputCadastrar($data);
        if ($resultadoValidacao !== true) {
            return $this->response->setJSON($resultadoValidacao);
        }
        
        $reservaModel = new ReservaModel();
        $reservaModel->db->transStart();
        try {
            foreach($data->interval as $r){
                $inicioReserva = DateTime::createFromFormat('Y-m-d H:i', $data->date.' '.$r->start);
                $fimReserva = clone $inicioReserva;
                $fimReserva->add(new DateInterval('PT'.$r->duration.'M'));
                
                $reservaEntity = new ReservaEntity();
                $reservaEntity->dataCadastro = (new DateTime())->format(('d/m/Y'));
                $reservaEntity->dataReserva = DateTime::createFromFormat('Y-m-d', $data->date)->format('d/m/Y');
                $reservaEntity->horaInicio = $r->start;
                $reservaEntity->horaFim = $fimReserva->format('H:i');
                $reservaEntity->tipo = ReservaEntity::TIPO_COMPARTILHADA;
                $reservaEntity->numeroConvidados = $data->people - 1;
                $reservaEntity->status = ReservaEntity::STATUS_ATIVO;
                $reservaEntity->turmaEscola = $data->isClass === true ? ReservaEntity::TURMA_ESCOLA_SIM : ReservaEntity::TURMA_ESCOLA_NAO;
                $reservaEntity->nomeEscola = $data->nameSchool;
                $reservaEntity->anoTurma = $data->yearClass;

                if (!$reservaModel->insert($reservaEntity, false)) {
                    return $this->prepareErrorJson($reservaModel->errors());
                }
                $reservaEntity->id = $reservaModel->getInsertID();
                $resPartEntity = new ReservaParticipanteEntity();
                $resPartEntity->Participante_id = $data->participantId;
                $resPartEntity->Reserva_id = $reservaEntity->id;
                $participanteModel = new ReservaParticipanteModel();
                if(!$participanteModel->insert($resPartEntity, false)){
                    return $this->prepareErrorJson(['Erro ao cadastrar Reserva Participante', ...$participanteModel->errors()]);
                }

                if($data->activity->type == 'oficina'){
                    $oficTematicaReserva = new OficinaTematicaReservaEntity();
                    $oficTematicaReserva->Reserva_id = $reservaEntity->id;
                    $oficTematicaReserva->OficinaTematica_id = $data->activity->id;
                    $oficTematicaReserva->observacao = $data->note;
                    $oficTemModel = new OficinaTematicaReservaModel();
                    if(!$oficTemModel->insert($oficTematicaReserva, false)){
                        return $this->prepareErrorJson(['Erro ao Vincular Oficina Reserva', ...$oficTemModel->errors()]);
                    }
                }
                if($data->activity->type == 'livre'){
                    $ativLivreEntity = new AtividadeLivreEntity();
                    $ativLivreEntity->Reserva_id = $reservaEntity->id;
                    $ativLivreEntity->descricao = $data->activity->description;
                    $ativLivreModel = new AtividadeLivreModel();
                    if(!$ativLivreModel->insert($ativLivreEntity, false)){
                        return $this->prepareErrorJson(['Erro ao Vincular Atividade Livre', ...$ativLivreModel->errors()]);
                    }
                    $ativLivreRecurso = new AtividadeLivreRecursoEntity();
                    $ativLivreRecurso->AtividadeLivre_id = $ativLivreModel->getInsertID();
                    $ativLivreRecursoModel = new AtividadeLivreRecursoModel();
                    foreach($data->activity->resourceIds as $r_id){
                        $ativLivreRecurso->RecursoTrabalho_id = $r_id;                        
                        if(!$ativLivreRecursoModel->insert($ativLivreRecurso, false)){
                            return $this->prepareErrorJson(['Erro ao Vincular Recursos à Atividade Livre', ...$ativLivreRecursoModel->errors()]);
                        }
                    }
                }

            }
            $reservaModel->db->transComplete();
            $sucesso = ['erro' => false, 'msg' => 'Cadastrado com sucesso!'];
            return $this->response->setJson($sucesso);
        } catch (\Exception $ex) {
            return $this->prepareErrorJson($ex->getMessage());
        }
    }
    
    private function prepareErrorJson(string|array $errors): ResponseInterface
    {   
        $msg = is_array($errors) ? implode("\n", $errors) : $errors;
        $error = ['erro' => true, 'msg' => $msg];
        return $this->response->setJson($error);
    }

    public function alterar() {
        $m = new ReservaModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $servicoModel = new ServicoModel();
        $configuracao = ConfiguracaoModel::getConfiguracao();
        $usarCalculoUsoEspaco = false;
        $servicoUsoEspacoId = 1;
        if ($configuracao instanceof ConfiguracaoEntity) {
            $usarCalculoUsoEspaco = (int) $configuracao->adicinarCalculoServico === ConfiguracaoEntity::ADICINAR_CALCULO_SERVICO_SIM;
            $servicoUsoEspacoId = (int) $configuracao->servicoUsoEspaco ?: 1;
        }
        $data = [
            'reserva' => $e,
            'servicosAtivos' => array_map(static function ($servico) {
                $valorBruto = (string) $servico->valor;
                $valorNumerico = str_contains($valorBruto, ',')
                    ? str_replace(['.', ','], ['', '.'], $valorBruto)
                    : $valorBruto;

                return [
                    'id'      => (int) $servico->id,
                    'nome'    => (string) $servico->Nome,
                    'valor'   => (float) $valorNumerico,
                    'unidade' => (string) ($servico->unidade ?? ''),
                ];
            }, $servicoModel->where('ativo', 1)->orderBy('Nome', 'ASC')->findAll()),
            'usarCalculoUsoEspaco' => $usarCalculoUsoEspaco,
            'servicoUsoEspacoId' => $servicoUsoEspacoId,
        ];
        return view('Painel/Reserva/alterar', $data);
    }

    public function doAlterar() {
        $m = new ReservaModel();
        $post = $this->request->getPost();
        $dataReserva = trim((string) ($post['dataReserva'] ?? ''));
        $horaEntrada = trim((string) ($post['horaEntrada'] ?? ''));
        $horaSaida = trim((string) ($post['horaSaida'] ?? ''));

        if ($horaEntrada !== '' && preg_match('/^\d{2}:\d{2}$/', $horaEntrada) === 1) {
            $dataHoraEntrada = DateTime::createFromFormat('d/m/Y H:i', $dataReserva . ' ' . $horaEntrada)
                ?: DateTime::createFromFormat('Y-m-d H:i', $dataReserva . ' ' . $horaEntrada);
            if ($dataHoraEntrada !== false) {
                $post['horaEntrada'] = $dataHoraEntrada->format('Y-m-d H:i:s');
            } else {
                $post['horaEntrada'] = $dataReserva . ' ' . $horaEntrada;
            }
        }

        if ($horaSaida !== '' && preg_match('/^\d{2}:\d{2}$/', $horaSaida) === 1) {
            $dataHoraSaida = DateTime::createFromFormat('d/m/Y H:i', $dataReserva . ' ' . $horaSaida)
                ?: DateTime::createFromFormat('Y-m-d H:i', $dataReserva . ' ' . $horaSaida);
            if ($dataHoraSaida !== false) {
                $post['horaSaida'] = $dataHoraSaida->format('Y-m-d H:i:s');
            } else {
                $post['horaSaida'] = $dataReserva . ' ' . $horaSaida;
            }
        }

        $entradaDate = null;
        $saidaDate = null;
        if (!empty($post['horaEntrada'])) {
            $entradaDate = DateTime::createFromFormat('Y-m-d H:i:s', $post['horaEntrada'])
                ?: DateTime::createFromFormat('d/m/Y H:i', $post['horaEntrada']);
        }
        if (!empty($post['horaSaida'])) {
            $saidaDate = DateTime::createFromFormat('Y-m-d H:i:s', $post['horaSaida'])
                ?: DateTime::createFromFormat('d/m/Y H:i', $post['horaSaida']);
        }
        if ($entradaDate !== null && $saidaDate !== null && $entradaDate > $saidaDate) {
            return $this->returnWithError('Hora de entrada não pode ser maior que a hora de saída.');
        }

        $this->request->setGlobal('post', $post);
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($post['id'] ?? $this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new ReservaEntity($post);
        try{ 
            $m->db->transStart();
            if ($m->update($en->id, $en)) { 
                $mAtividadeLivre = new AtividadeLivreModel();
                $idsDelete = array_map(fn($v):int => $v->id, $e->getListAtividadeLivre());
                if(count($idsDelete)>0){
                    $mAtividadeLivre->delete($idsDelete);
                }
                $AtividadeLivre = $this->request->getPost('AtividadeLivre') ?? [];
                foreach ($AtividadeLivre as $pp){
                    $pp['Reserva_id'] = $e->id;
                    $eAtividadeLivre = new AtividadeLivreEntity($pp);
                    if(!$mAtividadeLivre->insert($eAtividadeLivre, false)){
                        return $this->returnWithError($mAtividadeLivre->errors());
                    }
                }
                $mEventoReserva = new EventoReservaModel();
                $idsDelete = array_map(fn($v):int => $v->id, $e->getListEventoReserva());
                if(count($idsDelete)>0){
                    $mEventoReserva->delete($idsDelete);
                }
                $EventoReserva = $this->request->getPost('EventoReserva') ?? [];
                foreach ($EventoReserva as $pp){
                    $pp['Reserva_id'] = $e->id;
                    $eEventoReserva = new EventoReservaEntity($pp);
                    if(!$mEventoReserva->insert($eEventoReserva, false)){
                        return $this->returnWithError($mEventoReserva->errors());
                    }
                }
                $mOficinaTematicaReserva = new OficinaTematicaReservaModel();
                $idsDelete = array_map(fn($v):int => $v->id, $e->getListOficinaTematicaReserva());
                if(count($idsDelete)>0){
                    $mOficinaTematicaReserva->delete($idsDelete);
                }
                $OficinaTematicaReserva = $this->request->getPost('OficinaTematicaReserva') ?? [];
                foreach ($OficinaTematicaReserva as $pp){
                    $pp['Reserva_id'] = $e->id;
                    $eOficinaTematicaReserva = new OficinaTematicaReservaEntity($pp);
                    if(!$mOficinaTematicaReserva->insert($eOficinaTematicaReserva, false)){
                        return $this->returnWithError($mOficinaTematicaReserva->errors());
                    }
                }
                $mReservaParticipante = new ReservaParticipanteModel();
                $idsDelete = array_map(fn($v):int => $v->id, $e->getListReservaParticipante());
                if(count($idsDelete)>0){
                    $mReservaParticipante->delete($idsDelete);
                }
                $ReservaParticipante = $this->request->getPost('ReservaParticipante') ?? [];
                foreach ($ReservaParticipante as $pp){
                    $pp['Reserva_id'] = $e->id;
                    $eReservaParticipante = new ReservaParticipanteEntity($pp);
                    if(!$mReservaParticipante->insert($eReservaParticipante, false)){
                        return $this->returnWithError($mReservaParticipante->errors());
                    }
                }
                $m->db->transComplete();
                return $this->returnSucess('Cadastrado com sucesso!');
            } else { 
                return $this->returnWithError($m->errors());
            }
        }catch (\Exception $ex){ 
            return $this->returnWithError($ex->getMessage());
        }
    }

    public function pesquisar(){
        return view('Painel/Reserva/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new ReservaModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vReserva' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/Reserva/resposta',  $data);
    }
    
    public function listar() {
        $m = new ReservaModel();
        $data = [
            'vReserva' => $m->orderBy('id', 'DESC')->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/Reserva/listar', $data);
    }

    public function excluir() {
        $m = new ReservaModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $m->db->transStart();
        if ($m->delete($e->id)) { 
            $m->db->transComplete();
            return $this->returnSucess('Excluído com sucesso!');
        }
        return $this->returnWithError('Erro ao excluir registro. '.implode(' ', $m->errors()));
    }
    
    public function pesquisaModal() {
        $m = new ReservaModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vReserva' => $m->findAll(100)
        ];
        return view('Painel/Reserva/respostaModal', $data);
    }

    public function definirEntrada()
    {
        $m = new ReservaModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $participantes = $e->getListReservaParticipante();
        $participante = isset($participantes[0]) ? $participantes[0]->getParticipante() : null;
        if ($participante && (int) $participante->suspenso === ParticipanteEntity::SUSPENSO_SIM) {
            return $this->returnWithError('Participante suspenso.');
        }
        $hora = trim((string) $this->request->getPost('hora'));
        if ($hora === '' || !preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $hora)) {
            return $this->returnWithError('Hora inválida. Utilize o formato HH:MM.');
        }

        $dataHora = DateTime::createFromFormat('Y-m-d H:i', date('Y-m-d') . ' ' . $hora);
        if ($dataHora === false) {
            return $this->returnWithError('Não foi possível processar a hora informada.');
        }
        
        $e->horaEntrada = $dataHora->format('Y-m-d H:i:s');
        if(!$m->update($e->id, $e)){
            return $this->returnWithError('Erro ao definir "Hora Entrada". '. implode(' ', $m->errors()));
        }
        return $this->returnSucess('Entrada definida com sucesso!');
    }

    public function definirSaida()
    {
        $payload = $this->request->getJSON(true);
        if ($payload === null) {
            $payload = $this->request->getPost() ?? [];
        }

        $reservaId = (int) ($payload['reserva_id'] ?? $this->request->getUri()->getSegment(3));
        $querJson = $this->request->isAJAX() || str_contains((string) $this->request->getHeaderLine('Accept'), 'application/json') || $this->request->getHeaderLine('Content-Type') === 'application/json';

        if ($reservaId <= 0) {
            $msg = 'Reserva inválida.';
            return $querJson
                ? $this->response->setStatusCode(400)->setJSON(['erro' => true, 'msg' => $msg])
                : $this->returnWithError($msg);
        }

        $m = new ReservaModel();
        $e = $m->find($reservaId);
        if ($e === null) {
            return $querJson
                ? $this->response->setStatusCode(404)->setJSON(['erro' => true, 'msg' => 'Registro não encontrado.'])
                : $this->returnWithError('Registro não encontrado.');
        } 
        $hora = trim((string) ($payload['hora'] ?? ''));
        if ($hora === '' || !preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $hora)) {
            $msg = 'Hora inválida. Utilize o formato HH:MM.';
            return $querJson
                ? $this->response->setStatusCode(400)->setJSON(['erro' => true, 'msg' => $msg])
                : $this->returnWithError($msg);
        }

        $horaEntradaRaw = trim((string) $e->horaEntrada);
        if ($horaEntradaRaw === '' || $horaEntradaRaw === '0000-00-00 00:00:00') {
            $msg = 'Hora de entrada não definida para a reserva.';
            return $querJson
                ? $this->response->setStatusCode(400)->setJSON(['erro' => true, 'msg' => $msg])
                : $this->returnWithError($msg);
        }

        $entrada = DateTime::createFromFormat('Y-m-d H:i:s', $horaEntradaRaw) ?: DateTime::createFromFormat('d/m/Y H:i', $horaEntradaRaw);
        if ($entrada === false) {
            $msg = 'Não foi possível processar a hora de entrada.';
            return $querJson
                ? $this->response->setStatusCode(400)->setJSON(['erro' => true, 'msg' => $msg])
                : $this->returnWithError($msg);
        }

        $saida = DateTime::createFromFormat('Y-m-d H:i', $entrada->format('Y-m-d') . ' ' . $hora);
        if ($saida === false) {
            $msg = 'Não foi possível processar a hora de saída.';
            return $querJson
                ? $this->response->setStatusCode(400)->setJSON(['erro' => true, 'msg' => $msg])
                : $this->returnWithError($msg);
        }

        if ($saida <= $entrada) {
            $msg = 'Hora de saída deve ser posterior à hora de entrada.';
            return $querJson
                ? $this->response->setStatusCode(400)->setJSON(['erro' => true, 'msg' => $msg])
                : $this->returnWithError($msg);
        }

        $observacoes = trim((string) ($payload['observacoes'] ?? ''));
        $pago = filter_var($payload['pago'] ?? false, FILTER_VALIDATE_BOOL) || (string) ($payload['pago'] ?? '') === '1';
        $observacaoSemEspacos = preg_replace('/\s+/', '', $observacoes);
        if ($pago === false && strlen($observacaoSemEspacos) < 15) {
            $msg = 'Observações obrigatórias com pelo menos 15 caracteres quando a cobrança não for paga.';
            return $querJson
                ? $this->response->setStatusCode(400)->setJSON(['erro' => true, 'msg' => $msg])
                : $this->returnWithError($msg);
        }

        if ($pago === true && $observacoes === '') {
            $observacoes = 'Pagamento realizado na saída da reserva #' . $reservaId;
        }

        $reservaCobrancaModel = new ReservaCobrancaModel();
        $cobrancaModel = new CobrancaModel();
        $cobrancaServicoModel = new CobrancaServicoModel();
        $servicoModel = new ServicoModel();

        $link = $reservaCobrancaModel->where('Reserva_id', $reservaId)->first();
        $cobrancaId = $link ? (int) $link->Cobranca_id : 0;
        $totalCobranca = 0.0;

        if ($cobrancaId > 0) {
            $itens = $cobrancaServicoModel->where('Cobranca_id', $cobrancaId)->findAll();
            foreach ($itens as $item) {
                $servicoEntity = $servicoModel->find((int) $item->Servico_id);
                $valorServicoAtual = $servicoEntity ? $this->parseNumeroParaFloat((string) $servicoEntity->valor) : null;
                $valorUnitario = $this->valorUnitarioParaBRL($this->parseNumeroParaFloat((string) $item->valorUnitario), $valorServicoAtual);
                $quantidade = (int) $item->quantidade;
                $totalCobranca += $quantidade * $valorUnitario;
            }
        }

        $m->db->transStart();
        $e->horaSaida = $saida->format('Y-m-d H:i:s');
        if (!$m->update($e->id, $e)) {
            $m->db->transRollback();
            $msg = 'Erro ao definir "Hora Saída". ' . implode(' ', $m->errors());
            return $querJson
                ? $this->response->setStatusCode(500)->setJSON(['erro' => true, 'msg' => $msg])
                : $this->returnWithError($msg);
        }

        if ($cobrancaId > 0) {
            $cobrancaModel->skipValidation(true);
            $atualizou = $cobrancaModel->update($cobrancaId, [
                'valor'       => number_format($totalCobranca, 2, '.', ''),
                'observacoes' => $observacoes,
                'situacao'    => $pago ? 1 : 0,
            ]);
            $cobrancaModel->skipValidation(false);

            if (!$atualizou) {
                $m->db->transRollback();
                $msg = 'Erro ao atualizar cobrança. ' . implode(' ', $cobrancaModel->errors());
                return $querJson
                    ? $this->response->setStatusCode(500)->setJSON(['erro' => true, 'msg' => $msg])
                    : $this->returnWithError($msg);
            }
        }

        $m->db->transComplete();

        return $querJson
            ? $this->response->setJSON(['erro' => false, 'msg' => 'Saída definida com sucesso!', 'total' => $totalCobranca, 'pago' => $pago])
            : $this->returnSucess('Saída definida com sucesso!');
    }

    public function relatorio()
    {
        return view('Painel/Reserva/relatorio');
    }

    private function parseNumeroParaFloat(string $valor): float
    {
        $valor = trim($valor);
        if ($valor === '') {
            return 0.0;
        }

        if (str_contains($valor, ',')) {
            $valor = str_replace(['.', ','], ['', '.'], $valor);
        }

        return (float) $valor;
    }

    private function valorUnitarioParaBRL(float $valorUnitarioDb, ?float $valorServicoAtual = null): float
    {
        if ($valorServicoAtual !== null) {
            if (abs($valorUnitarioDb - $valorServicoAtual) < 0.01) {
                return $valorUnitarioDb;
            }
            if (abs(($valorUnitarioDb / 100) - $valorServicoAtual) < 0.01) {
                return $valorUnitarioDb / 100;
            }
        }

        return $valorUnitarioDb / 100;
    }

    public function litarServicosReserva()
    {
        $payload = $this->request->getJSON(true);
        if ($payload === null) {
            $payload = $this->request->getPost() ?? [];
        }

        $reservaId = (int) ($payload['reserva_id'] ?? 0);
        if ($reservaId <= 0) {
            return $this->response->setStatusCode(400)->setJSON([
                'erro' => true,
                'msg'  => 'Reserva inválida.',
            ]);
        }

        $reservaModel = new ReservaModel();
        $reserva = $reservaModel->find($reservaId);
        if (!($reserva instanceof ReservaEntity)) {
            return $this->response->setStatusCode(404)->setJSON([
                'erro' => true,
                'msg'  => 'Reserva não encontrada.',
            ]);
        }

        $reservaCobrancaModel = new ReservaCobrancaModel();
        $link = $reservaCobrancaModel->where('Reserva_id', $reservaId)->first();
        if ($link === null) {
            return $this->response->setJSON([
                'erro'     => false,
                'servicos' => [],
                'produtos' => [],
                'total'    => 0,
            ]);
        }

        $cobrancaId = (int) $link->Cobranca_id;
        if ($cobrancaId <= 0) {
            return $this->response->setJSON([
                'erro'     => false,
                'servicos' => [],
                'produtos' => [],
                'total'    => 0,
            ]);
        }

        $cobrancaServicoModel = new CobrancaServicoModel();
        $itens = $cobrancaServicoModel->where('Cobranca_id', $cobrancaId)->findAll();
        /*
        // PRODUTOS_DESATIVADOS
        $cobrancaProdutoModel = new CobrancaProdutoModel();
        $itensProduto = $cobrancaProdutoModel->where('Cobranca_id', $cobrancaId)->findAll();
        */

        $servicosMap = [];
        $produtosMap = [];
        $total = 0.0;

        foreach ($itens as $item) {
            $servicoId = (int) $item->Servico_id;

            $servicoEntity = $item->getServico();
            $nome = $servicoEntity ? (string) $servicoEntity->Nome : 'Serviço removido';
            $unidade = $servicoEntity ? (string) $servicoEntity->unidade : '';
            $valorServicoAtual = $servicoEntity ? $this->parseNumeroParaFloat((string) $servicoEntity->valor) : null;

            $valorUnitarioDb = $this->parseNumeroParaFloat((string) $item->valorUnitario);
            $valorUnitario = $this->valorUnitarioParaBRL($valorUnitarioDb, $valorServicoAtual);
            $quantidade = (int) $item->quantidade;
            $subtotal = $quantidade * $valorUnitario;
            $total += $subtotal;

            if (!isset($servicosMap[$servicoId])) {
                $servicosMap[$servicoId] = [
                    'id'         => $servicoId,
                    'nome'       => $nome,
                    'unidade'    => $unidade,
                    'quantidade' => 0,
                    'total'      => 0.0,
                ];
            } elseif ($servicosMap[$servicoId]['unidade'] === '' && $unidade !== '') {
                $servicosMap[$servicoId]['unidade'] = $unidade;
            }

            $servicosMap[$servicoId]['quantidade'] += $quantidade;
            $servicosMap[$servicoId]['total'] += $subtotal;
        }

        /*
        // PRODUTOS_DESATIVADOS
        foreach ($itensProduto as $item) {
            $produtoId = (int) $item->Produto_id;

            $produtoEntity = $item->getProduto();
            $nome = $produtoEntity ? (string) $produtoEntity->nome : 'Produto removido';
            $valorProdutoAtual = $produtoEntity ? $this->parseNumeroParaFloat((string) $produtoEntity->valor) : null;

            $valorUnitarioDb = $this->parseNumeroParaFloat((string) $item->valorUnitario);
            $valorUnitario = $this->valorUnitarioParaBRL($valorUnitarioDb, $valorProdutoAtual);
            $quantidade = (int) $item->quantidade;
            $subtotal = $quantidade * $valorUnitario;
            $total += $subtotal;

            if (!isset($produtosMap[$produtoId])) {
                $produtosMap[$produtoId] = [
                    'id'         => $produtoId,
                    'nome'       => $nome,
                    'quantidade' => 0,
                    'total'      => 0.0,
                ];
            }

            $produtosMap[$produtoId]['quantidade'] += $quantidade;
            $produtosMap[$produtoId]['total'] += $subtotal;
        }
        */

        $servicos = array_values(array_map(static function (array $item): array {
            $quantidade = (int) ($item['quantidade'] ?? 0);
            $total = (float) ($item['total'] ?? 0.0);
            $valorUnitario = $quantidade > 0 ? ($total / $quantidade) : 0.0;

            return [
                'id'           => (int) ($item['id'] ?? 0),
                'nome'         => (string) ($item['nome'] ?? ''),
                'unidade'      => (string) ($item['unidade'] ?? ''),
                'quantidade'   => $quantidade,
                'valorUnitario'=> $valorUnitario,
                'total'        => $total,
            ];
        }, $servicosMap));

        /*
        // PRODUTOS_DESATIVADOS
        $produtos = array_values(array_map(static function (array $item): array {
            $quantidade = (int) ($item['quantidade'] ?? 0);
            $total = (float) ($item['total'] ?? 0.0);
            $valorUnitario = $quantidade > 0 ? ($total / $quantidade) : 0.0;

            return [
                'id'           => (int) ($item['id'] ?? 0),
                'nome'         => (string) ($item['nome'] ?? ''),
                'quantidade'   => $quantidade,
                'valorUnitario'=> $valorUnitario,
                'total'        => $total,
            ];
        }, $produtosMap));
        */
        $produtos = [];

        return $this->response->setJSON([
            'erro'     => false,
            'servicos' => $servicos,
            'produtos' => $produtos,
            'total'    => $total,
        ]);
    }

    public function definirServicosReserva()
    {
        $payload = $this->request->getJSON(true);
        if ($payload === null) {
            $payload = $this->request->getPost() ?? [];
        }

        $reservaId = (int) ($payload['reserva_id'] ?? 0);
        $servicosPayload = $payload['servicos'] ?? [];
        if (!is_array($servicosPayload)) {
            $servicosPayload = [];
        }
        /*
        // PRODUTOS_DESATIVADOS
        $produtosPayload = $payload['produtos'] ?? [];
        if (!is_array($produtosPayload)) {
            $produtosPayload = [];
        }
        */
        $produtosPayload = [];

        if ($reservaId <= 0) {
            return $this->response->setStatusCode(400)->setJSON([
                'erro' => true,
                'msg'  => 'Reserva inválida.',
            ]);
        }

        $reservaModel = new ReservaModel();
        $reserva = $reservaModel->find($reservaId);
        if (!($reserva instanceof ReservaEntity)) {
            return $this->response->setStatusCode(404)->setJSON([
                'erro' => true,
                'msg'  => 'Reserva não encontrada.',
            ]);
        }

        $participantes = $reserva->getListReservaParticipante();
        $participanteId = isset($participantes[0]) ? (int) $participantes[0]->Participante_id : 0;
        if ($participanteId <= 0) {
            return $this->response->setStatusCode(400)->setJSON([
                'erro' => true,
                'msg'  => 'Reserva sem participante vinculado.',
            ]);
        }

        $servicosNormalizados = [];
        foreach ($servicosPayload as $item) {
            if (!is_array($item)) {
                continue;
            }
            $id = (int) ($item['id'] ?? 0);
            $quantidade = (int) ($item['quantidade'] ?? 0);
            if ($id <= 0) {
                continue;
            }
            if ($quantidade > 0) {
                $servicosNormalizados[$id] = $quantidade;
            }
        }

        /*
        // PRODUTOS_DESATIVADOS
        $produtosNormalizados = [];
        foreach ($produtosPayload as $item) {
            if (!is_array($item)) {
                continue;
            }
            $id = (int) ($item['id'] ?? 0);
            $quantidade = (int) ($item['quantidade'] ?? 0);
            if ($id <= 0) {
                continue;
            }
            if ($quantidade > 0) {
                $produtosNormalizados[$id] = $quantidade;
            }
        }
        */
        $produtosNormalizados = [];

        $reservaCobrancaModel = new ReservaCobrancaModel();
        $cobrancaModel = new CobrancaModel();
        $cobrancaServicoModel = new CobrancaServicoModel();
        $servicoModel = new ServicoModel();
        // PRODUTOS_DESATIVADOS: manter apenas para limpeza de dados antigos.
        $cobrancaProdutoModel = new CobrancaProdutoModel();
        /*
        $produtoModel = new ProdutoModel();
        */

        $reservaModel->db->transStart();

        try {
            $link = $reservaCobrancaModel->where('Reserva_id', $reservaId)->first();
            $cobrancaId = $link ? (int) $link->Cobranca_id : 0;

            if (empty($servicosNormalizados) && empty($produtosNormalizados)) {
                if ($cobrancaId > 0) {
                    $cobrancaServicoModel->where('Cobranca_id', $cobrancaId)->delete();
                    $cobrancaProdutoModel->where('Cobranca_id', $cobrancaId)->delete();
                    $reservaCobrancaModel->where('Reserva_id', $reservaId)->delete();
                    $cobrancaModel->delete($cobrancaId);
                }

                $reservaModel->db->transComplete();
                return $this->response->setJSON([
                    'erro' => false,
                    'msg'  => 'Consumo atualizado.',
                ]);
            }

            if ($cobrancaId <= 0) {
                $cobrancaData = [
                    'Participante_id' => $participanteId,
                    'data'            => date('Y-m-d'),
                    'valor'           => 0.01,
                    'observacoes'     => 'Cobrança gerada automaticamente para reserva #' . $reservaId,
                    'situacao'        => 0,
                ];

                if (!$cobrancaModel->insert($cobrancaData, false)) {
                    throw new \RuntimeException('Erro ao criar cobrança: ' . implode(' ', $cobrancaModel->errors()));
                }

                $cobrancaId = (int) $cobrancaModel->getInsertID();

                $linkData = [
                    'Reserva_id'  => $reservaId,
                    'Cobranca_id' => $cobrancaId,
                ];

                if (!$reservaCobrancaModel->insert($linkData, false)) {
                    throw new \RuntimeException('Erro ao vincular cobrança: ' . implode(' ', $reservaCobrancaModel->errors()));
                }
            }

            $existentes = $cobrancaServicoModel->where('Cobranca_id', $cobrancaId)->findAll();
            $mapExistentes = [];
            foreach ($existentes as $existente) {
                $servicoId = (int) $existente->Servico_id;
                if (!isset($mapExistentes[$servicoId])) {
                    $mapExistentes[$servicoId] = [];
                }
                $mapExistentes[$servicoId][] = $existente;
            }
            /*
            // PRODUTOS_DESATIVADOS
            $existentesProduto = $cobrancaProdutoModel->where('Cobranca_id', $cobrancaId)->findAll();
            $mapExistentesProduto = [];
            foreach ($existentesProduto as $existente) {
                $produtoId = (int) $existente->Produto_id;
                if (!isset($mapExistentesProduto[$produtoId])) {
                    $mapExistentesProduto[$produtoId] = [];
                }
                $mapExistentesProduto[$produtoId][] = $existente;
            }
            */

            $totalCobranca = 0.0;

            foreach ($servicosNormalizados as $servicoId => $quantidade) {
                if ($quantidade <= 0) {
                    if (isset($mapExistentes[$servicoId])) {
                        foreach ($mapExistentes[$servicoId] as $registro) {
                            $cobrancaServicoModel->delete($registro->id);
                        }
                        unset($mapExistentes[$servicoId]);
                    }
                    continue;
                }

                $registrosExistentes = $mapExistentes[$servicoId] ?? [];
                $registroExistente = !empty($registrosExistentes) ? array_shift($registrosExistentes) : null;
                $valorUnitarioRaw = null;

                if ($registroExistente !== null) {
                    foreach ($registrosExistentes as $duplicado) {
                        $cobrancaServicoModel->delete($duplicado->id);
                    }
                    $valorUnitarioRaw = $this->parseNumeroParaFloat((string) $registroExistente->valorUnitario);
                    $cobrancaServicoModel->skipValidation(true);
                    if (!$cobrancaServicoModel->update($registroExistente->id, ['quantidade' => $quantidade])) {
                        throw new \RuntimeException('Erro ao atualizar serviço: ' . implode(' ', $cobrancaServicoModel->errors()));
                    }
                    $cobrancaServicoModel->skipValidation(false);
                    unset($mapExistentes[$servicoId]);
                } else {
                    $servico = $servicoModel->find($servicoId);
                    if (!($servico instanceof \App\Entities\ServicoEntity)) {
                        throw new \RuntimeException('Serviço inválido: ' . $servicoId);
                    }

                    $valorServico = $this->parseNumeroParaFloat((string) $servico->valor);
                    $valorUnitarioRaw = (float) round($valorServico * 100);

                    $dadosInsercao = [
                        'Cobranca_id'   => $cobrancaId,
                        'Servico_id'    => $servicoId,
                        'quantidade'    => $quantidade,
                        'valorUnitario' => (int) $valorUnitarioRaw,
                    ];

                    if (!$cobrancaServicoModel->insert($dadosInsercao, false)) {
                        throw new \RuntimeException('Erro ao inserir serviço: ' . implode(' ', $cobrancaServicoModel->errors()));
                    }
                }

                $servico = $servicoModel->find($servicoId);
                $valorServicoAtual = $servico ? $this->parseNumeroParaFloat((string) $servico->valor) : null;
                $valorUnitarioBrl = $this->valorUnitarioParaBRL($valorUnitarioRaw ?? 0.0, $valorServicoAtual);
                $totalCobranca += $quantidade * $valorUnitarioBrl;
            }

            foreach ($mapExistentes as $restante) {
                foreach ($restante as $registro) {
                    $cobrancaServicoModel->delete($registro->id);
                }
            }

            /*
            // PRODUTOS_DESATIVADOS
            foreach ($produtosNormalizados as $produtoId => $quantidade) {
                if ($quantidade <= 0) {
                    if (isset($mapExistentesProduto[$produtoId])) {
                        foreach ($mapExistentesProduto[$produtoId] as $registro) {
                            $cobrancaProdutoModel->delete($registro->id);
                        }
                        unset($mapExistentesProduto[$produtoId]);
                    }
                    continue;
                }

                $registrosExistentes = $mapExistentesProduto[$produtoId] ?? [];
                $registroExistente = !empty($registrosExistentes) ? array_shift($registrosExistentes) : null;
                $valorUnitarioRaw = null;

                if ($registroExistente !== null) {
                    foreach ($registrosExistentes as $duplicado) {
                        $cobrancaProdutoModel->delete($duplicado->id);
                    }
                    $valorUnitarioRaw = $this->parseNumeroParaFloat((string) $registroExistente->valorUnitario);
                    $cobrancaProdutoModel->skipValidation(true);
                    if (!$cobrancaProdutoModel->update($registroExistente->id, ['quantidade' => $quantidade])) {
                        throw new \RuntimeException('Erro ao atualizar produto: ' . implode(' ', $cobrancaProdutoModel->errors()));
                    }
                    $cobrancaProdutoModel->skipValidation(false);
                    unset($mapExistentesProduto[$produtoId]);
                } else {
                    $produto = $produtoModel->find($produtoId);
                    if (!($produto instanceof \App\Entities\ProdutoEntity)) {
                        throw new \RuntimeException('Produto inválido: ' . $produtoId);
                    }

                    $valorProduto = $this->parseNumeroParaFloat((string) $produto->valor);
                    $valorUnitarioRaw = (float) round($valorProduto * 100);

                    $dadosInsercao = [
                        'Cobranca_id'   => $cobrancaId,
                        'Produto_id'    => $produtoId,
                        'quantidade'    => $quantidade,
                        'valorUnitario' => (int) $valorUnitarioRaw,
                    ];

                    if (!$cobrancaProdutoModel->insert($dadosInsercao, false)) {
                        throw new \RuntimeException('Erro ao inserir produto: ' . implode(' ', $cobrancaProdutoModel->errors()));
                    }
                }

                $produto = $produtoModel->find($produtoId);
                $valorProdutoAtual = $produto ? $this->parseNumeroParaFloat((string) $produto->valor) : null;
                $valorUnitarioBrl = $this->valorUnitarioParaBRL($valorUnitarioRaw ?? 0.0, $valorProdutoAtual);
                $totalCobranca += $quantidade * $valorUnitarioBrl;
            }

            foreach ($mapExistentesProduto as $restante) {
                foreach ($restante as $registro) {
                    $cobrancaProdutoModel->delete($registro->id);
                }
            }
            */

            $cobrancaModel->skipValidation(true);
            if (!$cobrancaModel->update($cobrancaId, ['valor' => number_format($totalCobranca, 2, '.', '')])) {
                throw new \RuntimeException('Erro ao atualizar cobrança: ' . implode(' ', $cobrancaModel->errors()));
            }
            $cobrancaModel->skipValidation(false);

            $reservaModel->db->transComplete();
            return $this->response->setJSON([
                'erro' => false,
                'msg'  => 'Consumo atualizado.',
            ]);
        } catch (\Throwable $exception) {
            $reservaModel->db->transRollback();
            return $this->response->setStatusCode(500)->setJSON([
                'erro' => true,
                'msg'  => $exception->getMessage(),
            ]);
        }
    }
}
