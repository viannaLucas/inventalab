<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class TemplateTermoModel extends BaseModel{
    
    protected $table = 'TemplateTermo';
    protected $allowedFields = ['nome', 'requererTermo', 'texto'];
    protected array $sanitizeHtmlFields = ['texto'];
    protected $beforeInsert = ['sanitizeHtmlFields'];
    protected $beforeUpdate = ['sanitizeHtmlFields'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'nome' => ['label'=> 'Nome', 'rules'=>'required'],
        'requererTermo' => ['label'=> 'Requerer Termo', 'rules'=>'required|in_list[0,1]'],
        'texto' => ['label'=> 'Texto', 'rules'=>'required'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\TemplateTermoEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['nome'])) $this->like('nome', $data['nome']); 
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){ 
        $this->orLike('nome', $searchTerm);        
        return $this;
    }
    
}
