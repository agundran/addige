&lt;?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Datatable extends CI_Controller {
         
    public function __construct()
   {
        parent::__construct();
        $this-&gt;load-&gt;library('datatables'); //load library upload bisa dilakukan disni atau disimpan di autoload
         
   }
 
    public function index()
    {
           $this-&gt;load-&gt;view('datatables'); //menampilkan halaman upload
    }
    function get_data()
    {
        $this-&gt;datatables-&gt;select('id,nama,alamat,email')
        -&gt;unset_column('id')
        -&gt;add_column('action',$this-&gt;button('$1'),'id') //menambahkan 1 kolom untuk custom field
        -&gt;from('mahasiswa');
         
        echo $this-&gt;datatables-&gt;generate(); //generatie hasil dari database
    }
    function button($param)
    {
        $html = &quot;&lt;a href='&quot;.base_url().&quot;index.php/datatables/edit/{$param}' &gt;Edit&lt;/a&gt;&quot;;
 
        return $html;
    }
     
}