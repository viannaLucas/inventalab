<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class ServicoModel extends BaseModel{
    
    protected $table = 'Servico';
    protected $allowedFields = ['Nome', 'descricao', 'valor', 'unidade', 'ativo'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'Nome' => ['label'=> 'Nome', 'rules'=>'required'],
        'descricao' => ['label'=> 'Descrição', 'rules'=>'required'],
        'valor' => ['label'=> 'Valor', 'rules'=>'required|greater_than[0]|decimal'],
        'unidade' => ['label'=> 'Unidade', 'rules'=>'required'],
        'ativo' => ['label'=> 'Ativo', 'rules'=>'required|in_list[0,1]'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\ServicoEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['Nome'])) $this->like('Nome', $data['Nome']);
        if(isset($data['descricao'])) $this->like('descricao', $data['descricao']);
        if(isset($data['unidade'])) $this->like('unidade', $data['unidade']);
        if(isset($data['ativo'])){
            $func = is_array($data['ativo']) ? 'whereIn' : 'where';
            $this->$func('ativo', $data['ativo']);
        } 
        if(isset($data['valorStart'])) $this->where('valor >=', CastCurrencyBR::set($data['valorStart']));
        if(isset($data['valorEnd'])) $this->where('valor <=', CastCurrencyBR::set($data['valorEnd']));
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){ 
        $this->orLike('Nome', $searchTerm);
        $this->orLike('descricao', $searchTerm);
        $this->orLike('unidade', $searchTerm);        
        return $this;
    }
    
}
