<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class RecursoTrabalhoModel extends BaseModel{
    
    protected $table = 'RecursoTrabalho';
    protected $allowedFields = ['nome', 'tipo', 'foto', 'marcaFabricante', 'descricao', 'requerHabilidade', 'usoExclusivo', 'situacaoTrabalho', 'quantidadeDisponivel'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'nome' => ['label'=> 'Nome', 'rules'=>'required'],
        'tipo' => ['label'=> 'Tipo', 'rules'=>'required|in_list[0,1]'],
        'foto' => ['label'=> 'Foto', 'rules'=>'required'],
        'marcaFabricante' => ['label'=> 'Marca do Fabricante', 'rules'=>'permit_empty'],
        'descricao' => ['label'=> 'Descrição', 'rules'=>'required'],
        'requerHabilidade' => ['label'=> 'Requer Habilidade', 'rules'=>'requiredIfValue[tipo,1]|inListIfRequired[tipo,1,0,1]'],
        'usoExclusivo' => ['label'=> 'Uso Exclusivo', 'rules'=>'requiredIfValue[tipo,1]|inListIfRequired[tipo,1,0,1]'],
        'situacaoTrabalho' => ['label'=> 'Situação Trabalho', 'rules'=>'required|in_list[0,1,2]'],
        'quantidadeDisponivel' => ['label'=> 'Situação Trabalho', 'rules'=>'required|greater_than[-1]|integer'],
    ];
    protected $validationRulesFiles = [
        'foto' => ['label'=> 'Foto', 'rules'=>'is_image[foto]|max_size[foto,10240]|ext_in[foto,jpg,jpeg,webp,png]'],
    ];
    protected $returnType = \App\Entities\RecursoTrabalhoEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['nome'])) $this->like('nome', $data['nome']);
        if(isset($data['marcaFabricante'])) $this->like('marcaFabricante', $data['marcaFabricante']);
        if(isset($data['descricao'])) $this->like('descricao', $data['descricao']);
        if(isset($data['tipo'])){
            $func = is_array($data['tipo']) ? 'whereIn' : 'where';
            $this->$func('tipo', $data['tipo']);
        }
        if(isset($data['requerHabilidade'])){
            $func = is_array($data['requerHabilidade']) ? 'whereIn' : 'where';
            $this->$func('requerHabilidade', $data['requerHabilidade']);
        }
        if(isset($data['usoExclusivo'])){
            $func = is_array($data['usoExclusivo']) ? 'whereIn' : 'where';
            $this->$func('usoExclusivo', $data['usoExclusivo']);
        }
        if(isset($data['situacaoTrabalho'])){
            $func = is_array($data['situacaoTrabalho']) ? 'whereIn' : 'where';
            $this->$func('situacaoTrabalho', $data['situacaoTrabalho']);
        } 
        if(isset($data['quantidadeDisponivelStart'])) $this->where('quantidadeDisponivel >=', $data['quantidadeDisponivelStart']);
        if(isset($data['quantidadeDisponivelEnd'])) $this->where('quantidadeDisponivel <=', $data['quantidadeDisponivelEnd']); 
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){ 
        $this->orLike('nome', $searchTerm);
        $this->orLike('marcaFabricante', $searchTerm);
        $this->orLike('descricao', $searchTerm);        
        return $this;
    }
    
}
