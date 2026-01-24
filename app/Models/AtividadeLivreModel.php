<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class AtividadeLivreModel extends BaseModel{
    
    protected $table = 'AtividadeLivre';
    protected $allowedFields = ['Reserva_id', 'descricao'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'Reserva_id' => ['label'=> 'Reserva', 'rules'=>'required|is_natural_no_zero|is_not_unique[Reserva.id]'],
        'descricao' => ['label'=> 'Descrição', 'rules'=>'required'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\AtividadeLivreEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['Reserva_id'])) $this->where('Reserva_id =', $data['Reserva_id']);  
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){         
        return $this;
    }
    
}
