<?
  function DataValida($dt) 
     { 
         $anovalido = false; $mesvalido = false; $diavalido = false;
         $formata = explode ("/", $dt);
		 if (count($formata) != 3) return 0;
         if ((is_numeric($formata[2])) and ($formata[2] > 00) and ($formata[2] < 99))
            {
              $anovalido = true;
              if ((is_numeric($formata[1])) and ($formata[1] <= 12))
                 {
                   $mesvalido = true;
                   if (is_numeric($formata[0]))
                      {   
                        switch($formata[1])
                           {  
                             case 01:
                                    if ($formata[0] <= 31)
                                        {
                                        $diavalido = true;}
                                         break;
                             case 02:
                                    if ($formata[0] <= 29)
                                        {
                                        $diavalido = true;}
                                        break;
                             case 03:
                                    if ($formata[0] <= 31)
                                        {$diavalido = true;}
                                        break; 
                             case 04:
                                    if ($formata[0] <= 30)
                                        {$diavalido = true;}
                                        break;                                                                                 
                             case 05:
                                    if ($formata[0] <= 31)
                                        {$diavalido = true;}
                                        break; 
                             case 06:
                                    if ($formata[0] <= 30)
                                        {$diavalido = true;}
                                        break; 
                             case 07:
                                    if ($formata[0] <= 31)
                                        {$diavalido = true;}
                                        break; 
                             case '08':
                                    if ($formata[0] <= 31)
                                        {$diavalido = true;}
                                        break; 
                             case '09':
                                    if ($formata[0] <= 30)
                                        {$diavalido = true;}
                                        break;
                             case 10:
                                    if ($formata[0] <= 31)
                                        {$diavalido = true;}
                                        break; 
                             case 11:
                                    if ($formata[0] <= 30)
                                        {$diavalido = true;}
                                        break; 
                             case 12:
                                    if ($formata[0] <= 31)
                                        {$diavalido = true;}
                                        break;  
                           } 
                    
                        }
                   }
              }
         
		 if (($anovalido == true) && ($mesvalido == true) && ($diavalido == true))
             return 1;
         else
             return 0;
     }
?>
