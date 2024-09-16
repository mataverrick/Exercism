<?php
    class Tournament{
        private array $finalTable ;

        public function tally(string $games){
            if(empty($games)){
                 return 'Team                           | MP |  W |  D |  L |  P';
            }
            
            $games=explode("\n",$games);
            
            foreach($games as $key=>$value){
                $this->tallyy($value,$key);
            }
            $this->print();
        }

        public function tallyy($gamesResult,$iteracion){
            $arrayTable = [];
            $datos=explode(";",$gamesResult);
            $result=$datos[2];
            
            for ($i=0; $i <count($datos)-1; $i++) { 

                $arrayTable = [
                    "Team"=>$datos[$i],
                    "MP"=>0,
                    "W" => 0,
                    "D" => 0,
                    "L" => 0,
                    "P" => 0,
                ];

                if($result=="draw"){
                    $arrayTable['MP'] = 1; 
                    $arrayTable['D'] = 1; 
                    $arrayTable['P'] = 1;
                    
                }else if(($result=="win" &&($i==0) || $result=="loss" &&($i==1))){
                    $arrayTable['MP'] = 1; 
                    $arrayTable['W'] = 1; 
                    $arrayTable['P'] = 3;
                }else{
                    $arrayTable['MP'] = 1; 
                    $arrayTable['L'] = 1; 
                }
                
                if($iteracion!=0){
                    $this->buscarYSumar($arrayTable);
                }else{
                    $this->insert($arrayTable);
                }
                
                
                $this->ordenarNombre();
                $this->ordenarPuntos();
            }
        }

        public function buscarYSumar($arrayTable){
            $encontrado=false;
            foreach($this->finalTable as &$row){
                if($row["Team"]==$arrayTable["Team"]){
                    $row["MP"] += $arrayTable["MP"];
                    $row["W"] += $arrayTable["W"];
                    $row["D"] += $arrayTable["D"];
                    $row["L"] += $arrayTable["L"];
                    $row["P"] += $arrayTable["P"];
                    $encontrado=true;
                    break;
                }
            }
            if(!$encontrado){
                $this->insert($arrayTable);
            }
        }

        public function ordenarNombre(){
            $aux=[];
            for ($i=0; $i < count($this->finalTable)-1; $i++) { 
                for($j=0;$j<count($this->finalTable)-1-$i;$j++){
                    if($this->finalTable[$j]["Team"]>$this->finalTable[$j+1]["Team"]){
                        $aux=$this->finalTable[$j];
                        $this->finalTable[$j]=$this->finalTable[$j+1];
                        $this->finalTable[$j+1]=$aux;
                    }
                }
            }
        }

        public function ordenarPuntos(){
            $aux=[];
            for ($i=0; $i < count($this->finalTable)-1; $i++) { 
                for($j=0;$j<count($this->finalTable)-1-$i;$j++){
                    if($this->finalTable[$j]["P"]< $this->finalTable[$j+1]["P"]){
                        $aux=$this->finalTable[$j];
                        $this->finalTable[$j]=$this->finalTable[$j+1];
                        $this->finalTable[$j+1]=$aux;
                    }
                }
            }
        }


        public function insert($array){
            $this->finalTable[]=$array;
        }

        public function print() {
            $output = "Team                           | MP |  W |  D |  L |  P\n";
            $rows = [];
            foreach ($this->finalTable as $row) {
                $rows[] = sprintf(
                    "%-30s | %2d | %2d | %2d | %2d | %2d",
                    $row["Team"],  
                    $row["MP"],    
                    $row["W"],     
                    $row["D"],     
                    $row["L"],     
                    $row["P"]      
                );
            }
            echo $output .= implode("\n", $rows);
            return $output;
        }
    }
?>

