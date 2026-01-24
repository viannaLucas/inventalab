<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class ReservaParticipanteModel extends BaseModel{
    
    protected $table = 'ReservaParticipante';
    protected $allowedFields = ['Participante_id', 'Reserva_id'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'Participante_id' => ['label'=> 'Participante', 'rules'=>'required|is_natural_no_zero|is_not_unique[Participante.id]'],
        'Reserva_id' => ['label'=> 'Reserva', 'rules'=>'required|is_natural_no_zero|is_not_unique[Reserva.id]'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\ReservaParticipanteEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['Participante_id'])) $this->where('Participante_id =', $data['Participante_id']); 
        if(isset($data['Reserva_id'])) $this->where('Reserva_id =', $data['Reserva_id']);  
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){         
        return $this;
    }
    
}
