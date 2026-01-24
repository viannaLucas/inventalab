<?PHP

namespace App\Models;
use App\Models\BaseModel;
use App\Entities\Cast\CastCurrencyBR;
use App\Entities\Cast\CastDateBR;
use App\Entities\ConfiguracaoEntity;

class ConfiguracaoModel extends BaseModel{
    
    protected $table = 'Configuracao';
    protected $allowedFields = ['lotacaoEspaco', 'intervaloEntrePesquisa', 'textoEmailConfirmacao', 'servicoUsoEspaco', 'adicinarCalculoServico'];
    protected array $sanitizeHtmlFields = ['textoEmailConfirmacao'];
    protected $beforeInsert = ['sanitizeHtmlFields'];
    protected $beforeUpdate = ['sanitizeHtmlFields'];
    protected $validationRules = [
    	'id'    => 'permit_empty|max_length[19]|is_natural_no_zero',
    
        'lotacaoEspaco' => ['label'=> 'Lotação Espaço', 'rules'=>'required|greater_than[0]|integer'],
        'adicinarCalculoServico' => ['label'=> 'Adicionar Cálculo Uso Espaço', 'rules'=>'required|greater_than_equal_to[0]|integer'],
        'intervaloEntrePesquisa' => ['label'=> 'Intervalo Entre Pesquisa', 'rules'=>'required|greater_than[0]|integer'],
        'textoEmailConfirmacao' => ['label'=> 'Texto Email Confirmação', 'rules'=>'required'],
        'servicoUsoEspaco' => ['label'=> 'Serviço Padrão Uso do Espaço', 'rules'=>'required|is_natural_no_zero|is_not_unique[Servico.id]'],
    ];
    protected $validationRulesFiles = [
    ];
    protected $returnType = \App\Entities\ConfiguracaoEntity::class;
    
    public function buildFindList(array $data){
        foreach ($data as $k => $v) {
            if($v == '') unset($data[$k]);
        }
        $this->builder()->resetQuery();
        if(isset($data['lotacaoEspacoStart'])) $this->where('lotacaoEspaco >=', $data['lotacaoEspacoStart']);
        if(isset($data['lotacaoEspacoEnd'])) $this->where('lotacaoEspaco <=', $data['lotacaoEspacoEnd']);
        if(isset($data['intervaloEntrePesquisaStart'])) $this->where('intervaloEntrePesquisa >=', $data['intervaloEntrePesquisaStart']);
        if(isset($data['intervaloEntrePesquisaEnd'])) $this->where('intervaloEntrePesquisa <=', $data['intervaloEntrePesquisaEnd']); 
        
        return $this;
    }
    
    public function buildFindModal(string $searchTerm){         
        return $this;
    }
    
    public static function getConfiguracao(): ConfiguracaoEntity
    {
        return (new ConfiguracaoModel())->find(1);
    }
}
