<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class PesquisaSatisfacaoModel extends BaseModel{
    
    protected $table = 'PesquisaSatisfacao';
    protected $allowedFields = ['Participante_id', 'resposta1', 'resposta2', 'resposta3', 'resposta4', 'resposta5', 'dataResposta', 'dataEnvio', 'respondido'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'Participante_id' => ['label'=> 'Participante', 'rules'=>'required|greater_than[0]|integer'],
        'resposta1' => ['label'=> 'Resposta 1', 'rules'=>'permit_empty|greater_than[0]|integer'],
        'resposta2' => ['label'=> 'Resposta 2', 'rules'=>'permit_empty|greater_than[0]|integer'],
        'resposta3' => ['label'=> 'Resposta 3', 'rules'=>'permit_empty|greater_than[0]|integer'],
        'resposta4' => ['label'=> 'Resposta 4', 'rules'=>'permit_empty'],
        'resposta5' => ['label'=> 'Resposta 5', 'rules'=>'permit_empty'],
        'dataResposta' => ['label'=> 'Data Resposta', 'rules'=>'permit_empty|valid_date[Y-m-d]'],
        'dataEnvio' => ['label'=> 'Data Envio', 'rules'=>'permit_empty|valid_date[Y-m-d]'],
        'respondido' => ['label'=> 'Respondido', 'rules'=>'in_list[0,1]'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\PesquisaSatisfacaoEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        // if(isset($data['Participante_idStart'])) $this->where('Participante_id >=', $data['Participante_idStart']);
        // if(isset($data['Participante_idEnd'])) $this->where('Participante_id <=', $data['Participante_idEnd']);
        if(isset($data['resposta1Start'])) $this->where('resposta1 >=', $data['resposta1Start']);
        if(isset($data['resposta1End'])) $this->where('resposta1 <=', $data['resposta1End']);
        if(isset($data['resposta2Start'])) $this->where('resposta2 >=', $data['resposta2Start']);
        if(isset($data['resposta2End'])) $this->where('resposta2 <=', $data['resposta2End']);
        if(isset($data['resposta3Start'])) $this->where('resposta3 >=', $data['resposta3Start']);
        if(isset($data['resposta3End'])) $this->where('resposta3 <=', $data['resposta3End']); 
        if(isset($data['dataRespostaStart'])) $this->where('dataResposta >=', CastDateBR::set($data['dataRespostaStart']));
        if(isset($data['dataRespostaEnd'])) $this->where('dataResposta <=', CastDateBR::set($data['dataRespostaEnd']));
        if(isset($data['dataEnvioStart'])) $this->where('dataEnvio >=', CastDateBR::set($data['dataEnvioStart']));
        if(isset($data['dataEnvioEnd'])) $this->where('dataEnvio <=', CastDateBR::set($data['dataEnvioEnd']));
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){         
        return $this;
    }
    
}
