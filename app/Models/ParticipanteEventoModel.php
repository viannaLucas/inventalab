<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class ParticipanteEventoModel extends BaseModel{
    
    protected $table = 'ParticipanteEvento';
    protected $allowedFields = ['Participante_id', 'Evento_id'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'Participante_id' => ['label'=> 'Participante', 'rules'=>'required|is_natural_no_zero|is_not_unique[Participante.id]'],
        'Evento_id' => ['label'=> 'Evento', 'rules'=>'required|is_natural_no_zero|is_not_unique[Evento.id]'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\ParticipanteEventoEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['Participante_id'])) $this->where('Participante_id =', $data['Participante_id']); 
        if(isset($data['Evento_id'])) $this->where('Evento_id =', $data['Evento_id']);  
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){         
        return $this;
    }
    
}
