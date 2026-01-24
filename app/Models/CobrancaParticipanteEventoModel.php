<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class CobrancaParticipanteEventoModel extends BaseModel{
    
    protected $table = 'CobrancaParticipanteEvento';
    protected $allowedFields = ['ParticipanteEvento_id', 'Cobranca_id'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'ParticipanteEvento_id' => ['label'=> 'Participante Evento', 'rules'=>'required|is_natural_no_zero|is_not_unique[ParticipanteEvento.id]'],
        'Cobranca_id' => ['label'=> 'Cobrança', 'rules'=>'required|is_natural_no_zero|is_not_unique[Cobranca.id]'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\CobrancaParticipanteEventoEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['ParticipanteEvento_id'])) $this->where('ParticipanteEvento_id =', $data['ParticipanteEvento_id']); 
        if(isset($data['Cobranca_id'])) $this->where('Cobranca_id =', $data['Cobranca_id']);  
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){         
        return $this;
    }
    
}
