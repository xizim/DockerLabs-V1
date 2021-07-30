<?PHP
    class INTERNATIONALSMSsend{

        protected $configs;
        
        protected $To=array();
        
        protected $Content='';

        function __construct($configs){
            $this->configs=$configs;
        }
        
        public function SetTo($address){
            $this->To=trim($address);
        }

        public function SetContent($content){
            $this->Content=$content;
        }
        
        public function AddVar($key,$val){
            $this->Vars[$key]=$val;
        }
        
        public function buildRequest(){
            $request=array();
            $request['to']=$this->To;
            $request['content']=$this->Content;
            return $request;
        }
        public function send(){
            $intersms=new intersms($this->configs);
            return $intersms->send($this->buildRequest());
        }
    }