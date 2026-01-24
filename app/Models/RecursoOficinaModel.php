<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class RecursoOficinaModel extends BaseModel{
    
    protected $table = 'RecursoOficina';
    protected $allowedFields = ['RecursoTrabalho_id', 'OficinaTematica_id'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'RecursoTrabalho_id' => ['label'=> 'Recurso Trabalho', 'rules'=>'required|is_natural_no_zero|is_not_unique[RecursoTrabalho.id]'],
        'OficinaTematica_id' => ['label'=> 'Oficina Temática', 'rules'=>'required|is_natural_no_zero|is_not_unique[OficinaTematica.id]'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\RecursoOficinaEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['RecursoTrabalho_id'])) $this->where('RecursoTrabalho_id =', $data['RecursoTrabalho_id']); 
        if(isset($data['OficinaTematica_id'])) $this->where('OficinaTematica_id =', $data['OficinaTematica_id']);  
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){         
        return $this;
    }
    
}
