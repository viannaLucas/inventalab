<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class AtividadeLivreRecursoModel extends BaseModel{
    
    protected $table = 'AtividadeLivreRecurso';
    protected $allowedFields = ['AtividadeLivre_id', 'RecursoTrabalho_id'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'AtividadeLivre_id' => ['label'=> 'Atividade Livre', 'rules'=>'required|is_natural_no_zero|is_not_unique[AtividadeLivre.id]'],
        'RecursoTrabalho_id' => ['label'=> 'Recurso Trabalho', 'rules'=>'required|is_natural_no_zero|is_not_unique[RecursoTrabalho.id]'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\AtividadeLivreRecursoEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['AtividadeLivre_id'])) $this->where('AtividadeLivre_id =', $data['AtividadeLivre_id']); 
        if(isset($data['RecursoTrabalho_id'])) $this->where('RecursoTrabalho_id =', $data['RecursoTrabalho_id']);  
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){         
        return $this;
    }
    
}
