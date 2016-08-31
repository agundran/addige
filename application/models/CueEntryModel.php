<?php

class CueEntryModel extends CI_Model{

	private $primary_key='Name';
	private $table_name='network';

	
		function __construct(){
	parent::__construct();
	}

	
	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $filter){
		if(empty($order_column)||empty($order_type)){		
		$this->db->order_by($this->primary_key,'asc');
		//$this->db->join('Rolename', 'users.Username = usersinroles.Username');
	}
	//else{
	  
		$query = $this->db->select('*')
                        ->from('network')
                        //->join('usersinroles', 'users.Username= usersinroles.Username')
						->like('network.Description', $filter, 'after')
                        ->get('', $limit, $offset); 
					   
		//$this->db->order_by($order_column,$order_type);
		//return $this->db->get($this->table_name, $limit, $offset);
		return $query;
		
	//}
	}

	public function getGUID(){
    	 mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
       	 $charid = strtolower(md5(uniqid(rand(), true)));
       	 $hyphen = chr(45);// "-"
      	 $uuid = substr($charid, 0, 8).$hyphen.substr($charid, 8, 4).$hyphen.substr($charid,12, 4).$hyphen.substr($charid,16,4).$hyphen.substr($charid,20,12); 
        return $uuid;
   	 
	}
	
	function create_user($Description, $Number, $TimeAvail, $Preroll, $Contact, $nCues, $Min1, $Max1, $Length1, $Code1, $Min2, $Max2, $Length2, $Code2, $NCCAlias, $Exclusion, $StartExclusion, $EndExclusion, $Name){
				/*
				$application_name = 'ADDIGEDOTNET';
				$password_question= 'What am I doing here?';
				$password_answer='Jw4WJqBOA2hYxSfoop9z/pAC+38=';
				$charid = strtolower(md5(uniqid(rand(), true)));
       	 		$hyphen = chr(45);// "-"
      			$creationdate =  date("Y-m-d H:i:s");
				$nodate = "0000-00-00 00:00:00";
				$initialctr = 0;
				$initialctr1 = 1;
				
				$myguid = substr($charid, 0, 8).$hyphen.substr($charid, 8, 4).$hyphen.substr($charid,12, 4).$hyphen.substr($charid,16,4).$hyphen.substr($charid,20,12); 
				*/
				
				$new_member_insert_data= array(
				
					'Description' => $Description,
					'Number' => $Number,
 					'TimeAvail' => $TimeAvail,
					'Preroll' => $Preroll,
					'Contact' => $Contact,
					'nCues' => $nCues,
					'Min1' => $Min1,
					'Max1' => $Max1,
					'Length1' => $Length1,
					'Code1' => $Code1,
					'Min2' => $Min2,
					'Max2' => $Max2,
					'Length2' => $Length2,
					'Code2' => $Code2,
					'NCCAlias' => $NCCAlias,
					'Exclusion' => $Exclusion,
					'StartExclusion' => $StartExclusion,
					'EndExclusion' => $EndExclusion,
					'Name' => $Name
					 
				
				/*
				'PKID' => $myguid,				
				'Username' => $Username,				
				'ApplicationName' => $application_name,				
				'Email' => $Email,	
				'IsApproved'=> $initialctr1,
				'LastActivityDate' => $creationdate, 
				'LastPasswordChangedDate'=>$creationdate, 
				'LastLoginDate'	=>$creationdate,
				'CreationDate'=>$creationdate ,		
				'LastLockedOutDate'=>$nodate,
				'IsLockedOut'=>$initialctr,
				'FailedPasswordAttemptCount'=>$initialctr,
				'FailedPasswordAnswerAttemptCount'=>$initialctr,
				'FailedPasswordAttemptWindowStart'=>$nodate ,
				
				'FailedPasswordAnswerAttemptWindowStart'=>$nodate ,
				'Operator' => $Operator,
				'PasswordQuestion' => $password_question,				
				'PasswordAnswer' => $password_answer,				
				'Password' => $this->encryptIt($Password)
				*/
				
				);
				/*
		$new_member_insert_data1= array(				
				'Username' => $Username,			
				'ApplicationName' => $application_name,				
				'Rolename' => $Rolename,
								
				);	
				*/						
				//$insert = 
				$this->db->insert('network',$new_member_insert_data );
				
				//$this->db->insert('usersinroles',$new_member_insert_data1);				
				return ;
		}
		
	function get_operator() { 		
			$this->db->select('ShortName');
     	    $this->db->order_by('ShortName', 'ASC');
      		$query=$this->db->get('operators');
      		$result = $query->result();
     		$drop_menu_operator_name = array();
        		foreach($result as $item){
        			$options[$item->ShortName] = $item->ShortName;
      				}
      		return $options;	
		}
		
	function count_all(){
	return $this->db->count_all($this->table_name);
	}

	function get_by_id($id){	
	$this->db->select('*')                        
						->where($this->primary_key,$id);
                       // ->join('usersinroles', 'users.Username= usersinroles.Username');
                        //->get('', $limit, $offset); 	
	return $this->db->get($this->table_name);
	}

	function save($person){
	$this->db->insert($this->table_name,$person);
	return $this->db->insert_id();
	}

	function update($id,$User)
	{
		$this->db->where($this->primary_key,$id);
		$this->db->update($this->table_name,$User);
		

	
	
	}

	function delete($id, $id2){
	$this->db->where($this->primary_key,$id);
	$this->db->delete($this->table_name);
	
	
	
	}


	
	function encryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5(md5( $cryptKey ))));
    return( $qEncoded );
	}


	function decryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ),MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $qDecoded );
	}
	
}

?>

