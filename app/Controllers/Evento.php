<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventoModel;
use App\Entities\EventoEntity;
use App\Models\ControlePresencaModel;
use App\Entities\ControlePresencaEntity;

use App\Models\EventoReservaModel;
use App\Entities\EventoReservaEntity;

use App\Models\ParticipanteEventoModel;
use App\Entities\ParticipanteEventoEntity;
use App\Entities\PresencaEventoEntity;
use App\Models\ParticipanteModel;
use App\Models\PresencaEventoModel;
use App\Models\ReservaModel;
use App\Models\CobrancaModel;
use App\Models\CobrancaParticipanteEventoModel;
use App\Models\CobrancaServicoModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\CobrancaParticipanteEventoEntity;
use App\Entities\ReservaEntity;
use App\Models\CobrancaProdutoModel;

class Evento extends BaseController {

    public function index() {
        return $this->cadastrar();
    }

    public function cadastrar() {
        return view('Painel/Evento/cadastrar');
    }

    public function verificarDatasReserva()
    {
        $payload = $this->request->getJSON(true);
        if ($payload === null) {
            $payload = $this->request->getPost() ?? [];
        }

        $reservas = $payload['reservas'] ?? [];
        $eventoId = isset($payload['eventoId']) ? (int)$payload['eventoId'] : 0;
        if (!is_array($reservas)) {
            return $this->response->setStatusCode(400)->setJSON([
                'ok' => false,
                'conflicts' => [],
                'message' => 'Formato de dados inválido.',
            ]);
        }

        if (empty($reservas)) {
            return $this->response->setJSON([
                'ok' => true,
                'conflicts' => [],
            ]);
        }

        $reservaModel = new ReservaModel();
        $reservasIgnoradas = [];
        if ($eventoId > 0) {
            $eventoReservaModel = new EventoReservaModel();
            $reservasEvento = $eventoReservaModel->where('Evento_id', $eventoId)->findAll();
            foreach($reservasEvento as $re){
                $reservasIgnoradas[] = $re->Reserva_id;
            }
        }
        $conflicts = [];

        foreach ($reservas as $reserva) {
            $dataBr = trim((string)($reserva['data'] ?? ''));
            $horaInicio = trim((string)($reserva['horaInicio'] ?? ''));
            $horaFim = trim((string)($reserva['horaFim'] ?? ''));
            $diaInteiro = (int)($reserva['diaInteiro'] ?? 0) === 1;
            $indice = isset($reserva['indice']) ? (int)$reserva['indice'] : null;

            if ($dataBr === '') {
                continue;
            }

            $date = \DateTime::createFromFormat('d/m/Y', $dataBr);
            if ($date === false) {
                continue;
            }

            if ($diaInteiro) {
                $horaInicioIso = '00:00:00';
                $horaFimIso = '23:59:59';
            } else {
                $horaInicioIso = $this->normalizarHora($horaInicio);
                $horaFimIso = $this->normalizarHora($horaFim, true);
                if ($horaInicioIso === null || $horaFimIso === null) {
                    continue;
                }
            }

            $builder = $reservaModel->builder();
            $builder->resetQuery();
            $builder->select('id, dataReserva, horaInicio, horaFim');
            $builder->where('dataReserva', $date->format('Y-m-d'));
            if (!empty($reservasIgnoradas)) {
                $builder->whereNotIn('id', $reservasIgnoradas);
            }
            $builder->groupStart()
                ->where('horaInicio <', $horaFimIso)
                ->where('horaFim >', $horaInicioIso)
            ->groupEnd();

            $existing = $builder->get()->getResultArray();

            if (!empty($existing)) {
                $conflicts[] = [
                    'indice' => $indice,
                    'data' => $date->format('d/m/Y'),
                    'horaInicio' => substr($horaInicioIso, 0, 5),
                    'horaFim' => substr($horaFimIso, 0, 5),
                    'reservas' => array_map(
                        static fn(array $row): array => [
                            'id' => (int)$row['id'],
                            'horaInicio' => substr((string)$row['horaInicio'], 0, 5),
                            'horaFim' => substr((string)$row['horaFim'], 0, 5),
                        ],
                        $existing
                    ),
                ];
            }
        }

        return $this->response->setJSON([
            'ok' => empty($conflicts),
            'conflicts' => $conflicts,
        ]);
    }

    public function doCadastrar() {
        d($this->request->getPost());
        $m = new EventoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = new EventoEntity($this->request->getPost());
        $e->imagem = $this->getRandomName('imagem');
        $ru = ['imagem' => false];
        $m->db->transStart();
        try {
            if ($m->insert($e, false)) { 
                d('inseriu evento');
                $mControlePresenca = new ControlePresencaModel();
                $ControlePresenca = $this->request->getPost('ControlePresenca') ?? [];
                foreach ($ControlePresenca as $pp){
                    $pp['Evento_id'] = $m->getInsertID();
                    $eControlePresenca = new ControlePresencaEntity($pp);
                    d('inserindo');
                    d($eControlePresenca);
                    if(!$mControlePresenca->insert($eControlePresenca, false)){
                        if($ru['imagem'] !== false) $m->deleteFile($ru['imagem']);
                        return $this->returnWithError($mControlePresenca->errors());
                    }
                    d('inserido controlepresenca');
                }
                $mEventoReserva = new EventoReservaModel();
                $EventoReserva = $this->request->getPost('ReservaEspaco') ?? [];
                d($EventoReserva);
                $reservaModel = new ReservaModel();
                foreach ($EventoReserva as $pp){
                    $reservaEntity = new ReservaEntity();
                    $reservaEntity->dataCadastro = date('d/m/Y');
                    $reservaEntity->dataReserva = $pp['data'];
                    $reservaEntity->horaInicio = $pp['horaInicio'];
                    $reservaEntity->horaFim = $pp['horaFim'];
                    $reservaEntity->tipo = ReservaEntity::TIPO_EXCLUSIVA;
                    $reservaEntity->numeroConvidados = $e->numeroVagas;
                    $reservaEntity->status = ReservaEntity::STATUS_ATIVO;
                    $reservaEntity->turmaEscola = ReservaEntity::TURMA_ESCOLA_NAO;
                    if(!$reservaModel->insert($reservaEntity,false)){
                        d('Erro ao criar reserva');
                        dd($reservaModel->errors());
                        return $this->returnWithError($reservaModel->errors());
                    }
                    $pp['Evento_id'] = $m->getInsertID();
                    $pp['Reserva_id'] = $reservaModel->getInsertID();
                    $eEventoReserva = new EventoReservaEntity($pp);
                    if(!$mEventoReserva->insert($eEventoReserva, false)){
                        if($ru['imagem'] !== false) $m->deleteFile($ru['imagem']);
                        return $this->returnWithError($mEventoReserva->errors());
                    }
                }
                $mParticipanteEvento = new ParticipanteEventoModel();
                $ParticipanteEvento = $this->request->getPost('ParticipanteEvento') ?? [];
                foreach ($ParticipanteEvento as $pp){
                    $pp['Evento_id'] = $m->getInsertID();
                    $eParticipanteEvento = new ParticipanteEventoEntity($pp);
                    if(!$mParticipanteEvento->insert($eParticipanteEvento, false)){
                        if($ru['imagem'] !== false) $m->deleteFile($ru['imagem']);
                        return $this->returnWithError($mParticipanteEvento->errors());
                    }
                }
                $ru['imagem'] = $m->uploadImage($this->request->getFile('imagem'), $e->imagem);
                $m->db->transComplete();
                return $this->returnSucess('Cadastrado com sucesso!');
            } else {
                if($ru['imagem'] !== false) $m->deleteFile($ru['imagem']);
                return $this->returnWithError($m->errors());
            }
        } catch (\Exception $ex) {
            if($ru['imagem'] !== false) $m->deleteFile($ru['imagem']);
            return $this->returnWithError($ex->getMessage());
        }
    }

    public function alterar() {
        $m = new EventoModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        } 
        $data = [
            'evento' => $e,
        ];
        return view('Painel/Evento/alterar', $data);
    }

    public function doAlterar() {
        $m = new EventoModel();
        $ef = $this->validateWithRequest($m->getValidationRulesFiles());
        if ($ef !== true) {
            return $this->returnWithError($ef);
        }
        $e = $m->find($this->request->getPost('id'));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $en = new EventoEntity($this->request->getPost());
        try{ 
            $ru['imagem'] = $m->uploadImage($this->request->getFile('imagem'), null, EventoEntity::folder);
            $en->imagem = $ru['imagem'] !== false ? $ru['imagem'] : $e->imagem;
            $m->db->transStart();
            if ($m->update($en->id, $en)) { 
                $mControlePresenca = new ControlePresencaModel();
                $idsDelete = array_map(fn($v):int => $v->id, $e->getListControlePresenca());
                if(count($idsDelete)>0){
                    $mControlePresenca->delete($idsDelete);
                }
                $ControlePresenca = $this->request->getPost('ControlePresenca') ?? [];
                foreach ($ControlePresenca as $pp){
                    $pp['Evento_id'] = $e->id;
                    $eControlePresenca = new ControlePresencaEntity($pp);
                    if(!$mControlePresenca->insert($eControlePresenca, false)){
                        if($ru['imagem'] !== false) $m->deleteFile($ru['imagem']);
                        return $this->returnWithError($mControlePresenca->errors());
                    }
                }


                $mEventoReserva = new EventoReservaModel();
                $reservaModel = new ReservaModel();
                $existingEventoReservas = $en->getListEventoReserva();
                $ReservaEspaco = $this->request->getPost('ReservaEspaco')??[];
                foreach($existingEventoReservas as $exp){
                    $deleted = true;
                    foreach($ReservaEspaco as $re){
                        if($exp->Reserva_id == $re['id']){
                            $deleted = false;
                        }
                    }
                    if($deleted){
                        $mEventoReserva->delete($exp->id);
                        $reservaModel->delete($exp->Reserva_id);
                    }
                }
                
                foreach ($ReservaEspaco as $pp) {
                    if($pp['id'] > 0) continue;
                    $reservaEntity = new ReservaEntity();
                    $reservaEntity->dataCadastro = date('d/m/Y');
                    $reservaEntity->dataReserva = $pp['data'] ?? '';
                    $reservaEntity->horaInicio = $pp['horaInicio'] ?? '';
                    $reservaEntity->horaFim = $pp['horaFim'] ?? '';
                    $reservaEntity->tipo = ReservaEntity::TIPO_EXCLUSIVA;
                    $reservaEntity->numeroConvidados = $en->numeroVagas;
                    $reservaEntity->status = ReservaEntity::STATUS_ATIVO;
                    $reservaEntity->turmaEscola = ReservaEntity::TURMA_ESCOLA_NAO;
                    if (!$reservaModel->insert($reservaEntity, false)) {
                        if ($ru['imagem'] !== false) $m->deleteFile($ru['imagem']);
                        return $this->returnWithError($reservaModel->errors());
                    }
                    $link = [
                        'Evento_id' => $e->id,
                        'Reserva_id' => $reservaModel->getInsertID(),
                    ];
                    $eEventoReserva = new EventoReservaEntity($link);
                    if (!$mEventoReserva->insert($eEventoReserva, false)) {
                        if ($ru['imagem'] !== false) $m->deleteFile($ru['imagem']);
                        return $this->returnWithError($mEventoReserva->errors());
                    }
                }

                $mParticipanteEvento = new ParticipanteEventoModel();
                $cobrancaModel = new CobrancaModel();
                $cobrancaParticipacaoEventoM = new CobrancaParticipanteEventoModel();
                $existingEventoParticipantes = $en->getListParticipanteEvento() ?? [];
                $ParticipanteEvento = $this->request->getPost('ParticipanteEvento')?? [];
                foreach($existingEventoParticipantes as $exp){
                    $deleted = true;
                    foreach($ParticipanteEvento as $re){
                        if($exp->Participante_id == $re['Participante_id']){
                            $deleted = false;
                        }
                    }
                    if($deleted){
                        $cpes = $cobrancaParticipacaoEventoM->where('ParticipanteEvento_id', $exp->id)
                            ->findAll();
                        foreach($cpes as $cpe){
                            $cobrancaParticipacaoEventoM->delete($cpe->id);
                            $cobranca = $cpe->getCobranca();
                            if (! (new CobrancaParticipanteEventoModel())->delete($cpe->id)) {
                                return $this->returnWithError('Erro ao excluir registro de "Cobrança Participante Evento".');
                            }
                            foreach($cobranca->getListCobrancaServico() as $cs){
                                if (! (new CobrancaServicoModel())->delete($cs->id)) {
                                    return $this->returnWithError('Erro ao excluir registro de "Cobrança Serviço".');
                                }
                            }
                            foreach($cobranca->getListCobrancaProduto() as $cp){
                                if (! (new CobrancaProdutoModel())->delete($cp->id)) {
                                    return $this->returnWithError('Erro ao excluir registro de "Cobrança Produto".');
                                }
                            }
                            if(!$cobrancaModel->delete($cpe->Cobranca_id)){
                                dd($cobrancaModel->errors());
                            }
                            
                        }
                        $mParticipanteEvento->delete($exp->id);
                        $erros = array_merge($mParticipanteEvento->errors());
                        if(count($erros)){
                            return $this->returnWithError($erros);
                        }

                    }
                }
                $ParticipanteEvento = $this->request->getPost('ParticipanteEvento') ?? [];
                foreach ($ParticipanteEvento as $pp){
                    $existe = false;
                    foreach($existingEventoParticipantes as $ep){
                        if($ep->Participante_id == $pp['Participante_id']) $existe = true;
                    }
                    if($existe) continue;
                    $pp['Evento_id'] = $e->id;
                    $eParticipanteEvento = new ParticipanteEventoEntity($pp);
                    if(!$mParticipanteEvento->insert($eParticipanteEvento, false)){
                        if($ru['imagem'] !== false) $m->deleteFile($ru['imagem']);
                        return $this->returnWithError($mParticipanteEvento->errors());
                    }
                }
                if($ru['imagem'] !== false) $m->deleteFile($e->imagem);
                $m->db->transComplete();
                return $this->returnSucess('Alterado com sucesso!');
            } else { 
                $m->deleteFiles($ru);
                return $this->returnWithError($m->errors());
            }
        }catch (\Exception $ex){ 
            if($ru['imagem'] != false){
                $m->deleteFile($ru['imagem']);
            }
            return $this->returnWithError($ex->getMessage());
        }
    }

    public function cobranca()
    {
        $participanteEventoId = (int) $this->request->getUri()->getSegment(3);
        if ($participanteEventoId <= 0) {
            return $this->returnWithError('Registro Participante Evento não encontrado.');
        }

        $participanteEventoModel = new ParticipanteEventoModel();
        $participanteEvento = $participanteEventoModel->find($participanteEventoId);
        if ($participanteEvento === null) {
            return $this->returnWithError('Registro Participante não encontrado.');
        }

        $evento = $participanteEvento->getEvento();
        if ($evento === null) {
            return $this->returnWithError('Registro Evento não encontrado.');
        }

        $cobrancaParticipanteEventoModel = new CobrancaParticipanteEventoModel();
        $link = $cobrancaParticipanteEventoModel
            ->where('ParticipanteEvento_id', $participanteEventoId)
            ->first();

        if ($link !== null) {
            $cobrancaId = (int) $link->Cobranca_id;
            if ($cobrancaId <= 0) {
                return $this->returnWithError('Cobrança não localizada');
            }

            $cobrancaModel = new CobrancaModel();
            $cobranca = $cobrancaModel->find($cobrancaId);
            if ($cobranca === null) {
                return $this->returnWithError('Cobrança não localizada');
            }

            return redirect()->to('Cobranca/alterar/' . $cobrancaId);
        }

        $cobrancaModel = new CobrancaModel();
        $cobrancaServicoModel = new CobrancaServicoModel();
        $valorEvento = (float) CastCurrencyBR::set((string) $evento->valor);
        if ($valorEvento <= 0) {
            return $this->returnWithError('Evento sem valor definido!');
        }
        $valorEventoDb = number_format($valorEvento, 2, '.', '');
        $cobrancaId = 0;

        $cobrancaModel->db->transStart();

        try {
            $cobrancaData = [
                'Participante_id' => $participanteEvento->Participante_id,
                'data' => date('Y-m-d'),
                'valor' => $valorEventoDb,
                'observacoes' => 'cobrança referente ao evento ' . $evento->nome,
                'situacao' => 0,
            ];

            if (!$cobrancaModel->insert($cobrancaData, false)) {
                throw new \RuntimeException('Erro ao criar cobrança: ' . implode(' ', $cobrancaModel->errors()));
            }

            $cobrancaId = (int) $cobrancaModel->getInsertID();
            if ($cobrancaId <= 0) {
                throw new \RuntimeException('Cobrança não localizada');
            }

            $linkData = [
                'ParticipanteEvento_id' => $participanteEventoId,
                'Cobranca_id' => $cobrancaId,
            ];

            if (!$cobrancaParticipanteEventoModel->insert($linkData, false)) {
                throw new \RuntimeException('Erro ao vincular cobrança: ' . implode(' ', $cobrancaParticipanteEventoModel->errors()));
            }

            $cobrancaServicoData = [
                'Cobranca_id' => $cobrancaId,
                'Servico_id' => $evento->Servico_id,
                'quantidade' => 1,
                'valorUnitario' => $valorEventoDb,
            ];

            if (!$cobrancaServicoModel->insert($cobrancaServicoData, false)) {
                throw new \RuntimeException('Erro ao criar cobrança serviço: ' . implode(' ', $cobrancaServicoModel->errors()));
            }

            $cobrancaModel->db->transComplete();
        } catch (\Throwable $ex) {
            $cobrancaModel->db->transRollback();
            return $this->returnWithError($ex->getMessage());
        }

        if ($cobrancaModel->db->transStatus() === false) {
            return $this->returnWithError('Erro ao criar cobrança.');
        }

        return redirect()->to('Cobranca/alterar/' . $cobrancaId);
    }
    
    public function pesquisar(){
        return view('Painel/Evento/pesquisar');
    }
    
    public function doPesquisar(){
        $m = new EventoModel();
        $m->buildFindList($this->request->getGet());
        $data = [
            'vEvento' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/Evento/resposta',  $data);
    }
    
    public function listar() {
        $m = new EventoModel();
        $data = [
            'vEvento' => $m->paginate(self::itensPaginacao),
            'pager' => $m->pager,
        ];
        return view('Painel/Evento/listar', $data);
    }

    public function excluir() {
        $m = new EventoModel();
        /** @var EventoEntity $e */
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Registro não encontrado.');
        }
        $db = db_connect();
        $db->transStart();
        /** @var ControlePresencaEntity $cp */
        foreach($e->getListControlePresenca() as $cp){
            /** @var PresencaEventoEntity $pe */
            foreach($cp->getListPresencaEvento() as $pe){
                if (! (new PresencaEventoModel())->delete($pe->id)) {
                    $db->transRollback();
                    return $this->returnWithError('Erro ao excluir registro de "Presença Evento".');
                }
            }
            if (! (new ControlePresencaModel())->delete($cp->id)) {
                $db->transRollback();
                return $this->returnWithError('Erro ao excluir registro de "Controle Presença".');
            }
        }
        /** @var ParticipanteEventoEntity $pae */
        foreach($e->getListParticipanteEvento() as $pae){
            $lCobrancaPartEvento = (new CobrancaParticipanteEventoModel())->where('ParticipanteEvento_id', $pae->id)->findAll();
            /** @var CobrancaParticipanteEventoEntity $cpe */
            foreach($lCobrancaPartEvento as $cpe){
                $cobranca = $cpe->getCobranca();
                if (! (new CobrancaParticipanteEventoModel())->delete($cpe->id)) {
                    return $this->returnWithError('Erro ao excluir registro de "Cobrança Participante Evento".');
                }
                foreach($cobranca->getListCobrancaServico() as $cs){
                     if (! (new CobrancaServicoModel())->delete($cs->id)) {
                        return $this->returnWithError('Erro ao excluir registro de "Cobrança Serviço".');
                    }
                }
                foreach($cobranca->getListCobrancaProduto() as $cp){
                     if (! (new CobrancaProdutoModel())->delete($cp->id)) {
                        return $this->returnWithError('Erro ao excluir registro de "Cobrança Produto".');
                    }
                }
                if (! (new CobrancaModel())->delete($cobranca->id)) {
                    return $this->returnWithError('Erro ao excluir registro de "Cobrança".');
                }
            }
            if (! (new ParticipanteEventoModel())->delete($pae->id)) {
                return $this->returnWithError('Erro ao excluir registro de "Participante Evento".');
            }
        }
        /** @var EventoReservaEntity $er */
        foreach($e->getListEventoReserva() as $er){
            $reserva = $er->getReserva();
            if (! (new EventoReservaModel())->delete($er->id)) {
                return $this->returnWithError('Erro ao excluir registro de "Evento Reserva".');
            }

            if (! (new ReservaModel())->delete($reserva->id)) {
                return $this->returnWithError('Erro ao excluir registro de "Reserva".');
            }
        }

        if ($m->delete($e->id)) { 
            $m->deleteFile($e->imagem);
            $db->transComplete();
            return $this->returnSucess('Excluído com sucesso!');
        }
        return $this->returnWithError('Erro ao excluir registro.'. implode(' ', $db->error()));
    }

    private function normalizarHora(string $hora, bool $isFim = false): ?string
    {
        $hora = trim($hora);
        if ($hora === '') {
            return null;
        }

        $time = \DateTime::createFromFormat('H:i:s', $hora);
        if ($time instanceof \DateTimeInterface) {
            if ($isFim && $time->format('H:i:s') === '23:59:00') {
                return '23:59:59';
            }
            return $time->format('H:i:s');
        }

        $time = \DateTime::createFromFormat('H:i', $hora);
        if ($time instanceof \DateTimeInterface) {
            $normalized = $time->format('H:i:s');
            if ($isFim && $normalized === '23:59:00') {
                return '23:59:59';
            }
            return $normalized;
        }

        return null;
    }

    public function pesquisaModal() {
        $m = new EventoModel();
        $m->buildFindModal($this->request->getGet('searchTerm'));
        $data = [
            'vEvento' => $m->findAll(100)
        ];
        return view('Painel/Evento/respostaModal', $data);
    }

    public function controlePresenca()
    {
        $m = new EventoModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Evento não encontrado.');
        } 
        $controlePresencaM = new ControlePresencaModel();
        $cpe = $controlePresencaM->find($this->request->getUri()->getSegment(4));
        $data = [
            'evento' => $e,
            'controlePresenca' => $cpe,
        ];
        return view('Painel/Evento/controlePresenca', $data);
    }

    public function definirPresenca()
    {   
        $controlePresencaE = (new ControlePresencaModel())->find($this->request->getUri()->getSegment(3));
        if ($controlePresencaE === null) {
            return $this->response->setJSON(["erro"=>true, "mensagem"=>'Controle Presença inválido!']);
        } 

        $participanteEventoM = new ParticipanteEventoModel();
        $participanteEventoE = $participanteEventoM->buildFindList(
            ['Participante_id'=>$this->request->getUri()->getSegment(4), 
            'Evento_id'=> $controlePresencaE->getEvento()->id]
        )->first();

        if ($participanteEventoE === null) {
            return $this->response->setJSON(["erro"=>true, "mensagem"=>'Participante não encontrado no evento.']);
        } 

        $presencaEvento = new PresencaEventoModel();
        $presencaEventoE = $presencaEvento->buildFindList(['ParticipanteEvento_id'=> $participanteEventoE->id, 
            'ControlePresenta_id'=>$controlePresencaE->id])->first();

        $presencaEventoM = new PresencaEventoModel();
        if($presencaEventoE == null){
            $presencaEventoE = new PresencaEventoEntity();
            $presencaEventoE->ParticipanteEvento_id = $participanteEventoE->id;
            $presencaEventoE->ControlePresenta_id = $controlePresencaE->id;
            $presencaEventoE->presente = PresencaEventoEntity::PRESENCA_SIM;
            if(!$presencaEventoM->insert($presencaEventoE, false)){
                return $this->response->setJSON(["erro"=>true, "mensagem"=>"Erro registrar presença! \n".implode("\n",$presencaEventoM->errors())]);
            }
        }
        $presencaEventoE->presenca = PresencaEventoEntity::PRESENCA_SIM;
        if(!$presencaEventoM->update($presencaEventoE->id, $presencaEventoE)){
            return $this->response->setJSON(["erro"=>true, "mensagem"=>"Erro atualiza presença! \n".implode("\n",$presencaEventoM->errors())]);
        }
        return $this->response->setJSON(["erro"=>false, "mensagem"=>'Presença registrada.']);
    }

    public function getPresentesEmControle()
    {
        $controlePresencaE = (new ControlePresencaModel())->find($this->request->getUri()->getSegment(3));
        if ($controlePresencaE === null) {
            return $this->response->setJSON(["erro"=>true, "mensagem"=>'Controle Presença inválido!']);
        } 
        
        $db = \Config\Database::connect();
        $ids = $db->table('PresencaEvento')->select("Participante_id as id")
            ->join('ParticipanteEvento', 'ParticipanteEvento.id = ParticipanteEvento_id')
            ->where('ControlePresenta_id', $controlePresencaE->id)->get()->getResultArray();
        
        return $this->response->setJSON(array_column($ids, 'id'));
    }

    public function imprimirListaPresenca(){
        $m = new EventoModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Evento não encontrado.');
        } 
        $controlePresencaM = new ControlePresencaModel();
        $cpe = $controlePresencaM->find($this->request->getUri()->getSegment(4));
        $data = [
            'evento' => $e,
            'controlePresenca' => $cpe,
        ];
        if($cpe == null){
            return view('Painel/Evento/selecionarControlePresenca', $data);
        }
        return view('Painel/Evento/imprimirControlePresenca', $data);
    }

    public function imprimirEntregaMaterial(){
        $m = new EventoModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Evento não encontrado.');
        } 
        $data = [
            'evento' => $e,
        ];
        return view('Painel/Evento/imprimirEntregaMaterial', $data);
    }

    public function exportarListaParticipante()
    {
        $m = new EventoModel();
        $e = $m->find($this->request->getUri()->getSegment(3));
        if ($e === null) {
            return $this->returnWithError('Evento não encontrado.');
        } 
        $vParticipante = [];
        foreach($e->getListParticipanteEvento() as $pe){
            $vParticipante[] = $pe->getParticipante();
        }

        usort($vParticipante, static function ($a, $b) {
            return strcasecmp((string) ($a->nome ?? ''), (string) ($b->nome ?? ''));
        });

        $stream = fopen('php://temp', 'r+');
        fputcsv($stream, ['Nome', 'Email', 'Telefone', 'Data Nascimento'], ';');

        foreach ($vParticipante as $participante) {
            $nome = (string) ($participante->nome ?? '');
            $email = (string) ($participante->email ?? '');
            $telefone = (string) ($participante->telefone ?? '');
            $dataNascimento = $participante->dataNascimento;
            if ($dataNascimento instanceof \DateTimeInterface) {
                $dataNascimento = $dataNascimento->format('d/m/Y');
            } else {
                $dataNascimento = (string) $dataNascimento;
            }

            fputcsv($stream, [$nome, $email, $telefone, $dataNascimento], ';');
        }

        rewind($stream);
        $csvData = stream_get_contents($stream);
        fclose($stream);

        $eventoSlug = (string) ($e->nome ?? '');
        if ($eventoSlug !== '') {
            helper('text');
            $eventoSlug = convert_accented_characters($eventoSlug);
            $eventoSlug = strtolower($eventoSlug);
            $eventoSlug = preg_replace('/[^a-z0-9]+/', '_', $eventoSlug);
            $eventoSlug = trim($eventoSlug, '_');
        }
        if ($eventoSlug === '') {
            $eventoSlug = 'lista';
        }

        $filename = 'participantes_evento_' . $eventoSlug . '_' . date('Ymd_His') . '.csv';

        return $this->response
            ->setHeader('Content-Type', 'text/csv; charset=UTF-8')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody("\xEF\xBB\xBF" . $csvData);
    }
}
