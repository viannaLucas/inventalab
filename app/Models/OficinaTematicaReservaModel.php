<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class OficinaTematicaReservaModel extends BaseModel{
    
    protected $table = 'OficinaTematicaReserva';
    protected $allowedFields = ['Reserva_id', 'OficinaTematica_id', 'observacao'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'Reserva_id' => ['label'=> 'Reserva', 'rules'=>'required|is_natural_no_zero|is_not_unique[Reserva.id]'],
        'OficinaTematica_id' => ['label'=> 'Oficina Temática', 'rules'=>'required|is_natural_no_zero|is_not_unique[OficinaTematica.id]'],
        'observacao' => ['label'=> 'Observação', 'rules'=>'permit_empty'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\OficinaTematicaReservaEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['Reserva_id'])) $this->where('Reserva_id =', $data['Reserva_id']); 
        if(isset($data['OficinaTematica_id'])) $this->where('OficinaTematica_id =', $data['OficinaTematica_id']);  
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){         
        return $this;
    }
    
}
