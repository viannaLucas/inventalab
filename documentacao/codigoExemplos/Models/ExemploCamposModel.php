<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;

class ExemploCamposModel extends BaseModel{
    
    protected $table = 'ExemploCampos';
    protected $allowedFields = ['tipoTexto', 'tipoImagem', 'tipoArquivo', 'tipoData', 'tipoNumero', 'tipoReal', 'tipoTextarea', 'tipoCPF', 'tipoCNPJ', 'tipoEmail', 'tipoSelect', 'tipoTelefone', 'tipoSenha', 'tipoEditor', 'foreignkey'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'tipoTexto' => ['label'=> 'Tipo Texto', 'rules'=>'required'],
        'tipoImagem' => ['label'=> 'Tipo Imagem', 'rules'=>'required'],
        'tipoArquivo' => ['label'=> 'Tipo Arquivo', 'rules'=>'required'],
        'tipoData' => ['label'=> 'Tipo Data', 'rules'=>'required|valid_date[Y-m-d]'],
        'tipoNumero' => ['label'=> 'Tipo Número', 'rules'=>'required|greater_than[0]|integer'],
        'tipoReal' => ['label'=> 'Tipo Real', 'rules'=>'required|greater_than[0]|decimal'],
        'tipoTextarea' => ['label'=> 'Tipo Textarea', 'rules'=>'required'],
        'tipoCPF' => ['label'=> 'Tipo CPF', 'rules'=>'required|cpf'],
        'tipoCNPJ' => ['label'=> 'Tipo CNPJ', 'rules'=>'required|cnpj'],
        'tipoEmail' => ['label'=> 'Tipo Email', 'rules'=>'required|valid_email'],
        'tipoSelect' => ['label'=> 'Tipo Select', 'rules'=>'required|in_list[0,1]'],
        'tipoTelefone' => ['label'=> 'Tipo Telefone', 'rules'=>'required'],
        'tipoSenha' => ['label'=> 'Tipo Senha', 'rules'=>'required'],
        'tipoEditor' => ['label'=> 'Tipo Editor', 'rules'=>'required'],
        'foreignkey' => ['label'=> 'Foreignkey', 'rules'=>'required|is_natural_no_zero|is_not_unique[TabelaFK.id]'],
    ];
    protected $validationRulesFiles = [
        'tipoImagem' => ['label'=> 'Tipo Imagem', 'rules'=>'is_image[tipoImagem]|max_size[foto,10240]|ext_in[tipoImagem,jpg,jpeg,webp,png]'],
        'tipoArquivo' => ['label'=> 'Tipo Arquivo', 'rules'=>'ext_in[tipoArquivo,doc,pdf,xls]|max_size[tipoArquivo,20480]'],
    ];
    protected $returnType = \App\Entities\ExemploCamposEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['foreignkey'])) $this->where('foreignkey =', $data['foreignkey']); 
        if(isset($data['tipoTexto'])) $this->like('tipoTexto', $data['tipoTexto']);
        if(isset($data['tipoTelefone'])) $this->like('tipoTelefone', $data['tipoTelefone']);
        if(isset($data['tipoSenha'])) $this->like('tipoSenha', $data['tipoSenha']);
        if(isset($data['tipoSelect'])){
            $func = is_array($data['tipoSelect']) ? 'whereIn' : 'where';
            $this->$func('tipoSelect', $data['tipoSelect']);
        }
        if(isset($data['tipoNumeroStart'])) $this->where('tipoNumero >=', $data['tipoNumeroStart']);
        if(isset($data['tipoNumeroEnd'])) $this->where('tipoNumero <=', $data['tipoNumeroEnd']); 
        if(isset($data['tipoRealStart'])) $this->where('tipoReal >=', CastCurrencyBR::set($data['tipoRealStart']));
        if(isset($data['tipoRealEnd'])) $this->where('tipoReal <=', CastCurrencyBR::set($data['tipoRealEnd']));
        if(isset($data['tipoDataStart'])) $this->where('tipoData >=', CastDateBR::set($data['tipoDataStart']));
        if(isset($data['tipoDataEnd'])) $this->where('tipoData <=', CastDateBR::set($data['tipoDataEnd']));
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){ 
        $this->orLike('tipoTexto', $searchTerm);
        $this->orLike('tipoTelefone', $searchTerm);
        $this->orLike('tipoSenha', $searchTerm);        
        return $this;
    }
    
}
