<?php
/**
 * Created by PhpStorm.
 * User: pablo
 * Date: 14/05/15
 * Time: 14:06
 */

class cInfoView {

    public function PrintExits($arrayLugar)
    {
        echo ("<br/><br/>");
        echo ("<u>Salidas visibles:</u> ");
        for ($i = 0; $i < count($arrayLugar['salidas']); $i++)
        {
            if (($i+1) < count($arrayLugar['salidas']))
            {
                // Las de enmedio
                if ($i > 0)
                {
                    echo ($arrayLugar['salidas'][$i]['nombreSalida'].", ");
                } else {
                    echo ($arrayLugar['salidas'][$i]['nombreSalida']." ");
                }

            } else {
                // La ultima que imprime
                if ($i == 0)
                {
                    echo ($arrayLugar['salidas'][$i]['nombreSalida']);
                } else {
                    echo ("y ".$arrayLugar['salidas'][$i]['nombreSalida']);
                }

            }
        }
    }

} 