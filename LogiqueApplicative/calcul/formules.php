<?php

//Calcul le nombre de porcs en engraissement : nbpoe=SI(naissage="oui";SI(dpn="vtpe";0;SI(dpn="epcf";nbt*nbps/nbcy*(1-mse);nbpe));nbpe)
function nbpoe($array)
{
    if (getValue('naissage', $array) == "Oui") {
        if (getValue('dpn', $array) == "VTPE") {
            return 0;
        } else if (getValue('dpn', $array) == "EPCF") {
            return (getValue('nbt', $array) * getValue('nbps', $array)) / (getValue('nbcy', $array) * (1 - (getValue('mse', $array) / 100)));
        } else {
            return getValue('nbpe', $array);
        }
    } else {
        return getValue('nbpe', $array);
    }
}

function nbtm($array)
{
    $ret = 0;

    if (getValue('naissage', $array) == 'Non')
        return $ret;
    else if (getValue('ceb', $array) == '4 bandes')
        $ret = getValue('nbt', $array) / getValue('ceb', $array);
    else
        $ret = getValue('nbt', $array) / getValue('ceb', $array) * 2;

    return round($ret);
}

function nbtg($array)
{
    $ret = 0;

    if (getValue('naissage', $array) == 'Non')
        return $ret;
    else if (getValue('ceb', $array) == '4 bandes')
        $ret = getValue('nbt', $array) / getValue('ceb', $array) * 3;
    else
        $ret = getValue('nbt', $array) / getValue('ceb', $array) * 5;

    return round($ret);
}

//*********************************************************************************************************

function ctt($array)
{
    if (getValue('naissage', $array) == 'Non')
        return 0;
    else
        return getValue('nbt', $array) * getValue('pat', $array);
}

function ctv($array)
{
    if (getValue('naissage', $array) == 'Non')
        return 0;
    else
        return getValue('nbv', $array) * getValue('pav', $array);
}

function cte($array)
{
    if (getValue('naissage', $array) == 'Oui')
        return 0;
    else
        return getValue('nbpe', $array) * getValue('pvp', $array);
}

function ctd($array)
{
    return ctt($array) + ctv($array) + cte($array);
}

function ahb($array, $arrayF)
{
    $NBTM = nbtm($array);
    $NBTG = nbtg($array);
    $NBPOE = nbpoe($array);

    $res1 = (getValue('lt', $array) * getValue('cmt', $array)) + (getValue('lce', $array) * getValue('cmce', $array));

    if (getValue('hm', $array) != "Cabanes") {
        $res1 += 0;
    } else {
        $res1 += (getValue('cpmc', $arrayF) * $NBTM);
    }

    if (getValue('hg', $array) != "Cabanes") {
        $res1 += 0;
    } else {
        $res1 += (getValue('cpgc', $arrayF) * $NBTG);
    }

    if (getValue('hpe', $array) != "Cabanes") {
        $res1 += 0;
    } else {
        $res1 += (getValue('cpec', $arrayF) * $NBPOE);
    }

    if (getValue('hapv', $array) != "Cabanes") {
        $res1 += 0;
    } else {
        $res1 += (getValue('cppc', $arrayF) * getValue('nbps', $array) / getValue('nbcy', $array) * $NBTG);
    }

    $res1 += (getValue('nbse', $array) + getValue('nbslg', $array)) * getValue('cs', $array);
    
    return round($res1,2);
}

function cb($array)
{
    return getValue('mbnm', $array) + getValue('mbng', $array) + getValue('mbnpav', $array) + getValue('mbne', $array) + getValue('mab', $array);
}

function caciav7($array, $arrayF)
{
    $ahb = ahb($array, $arrayF);

    if (getValue('financement', $array) == 'Emprunt') {
		if (getValue('ea', $array) == 'NE' || getValue('ea', $array) == 'EESP' ) {
			$res1 = ((ctd($array) + $ahb) * getValue('ti', $arrayF) / (1 - pow(1 + getValue('ti', $arrayF), -getValue('dem', $arrayF))));
		} else {
			$res1 = $ahb * getValue('ti', $arrayF) / (1 - (1 - pow(1 + getValue('ti', $arrayF), -getValue('dem', $arrayF))));
		}
    } else {

        if ((ctd($array) + $ahb) < getValue('fp', $array)) {
			if (getValue('ea', $array) == 'NE' || getValue('ea', $array) == 'EESP' ) {
				$res1 = ((ctd($array) + $ahb) * getValue('icci', $arrayF) / (1 - pow(1 + getValue('icci', $arrayF), -getValue('dem', $arrayF))));
			} else {
				$res1 = $ahb * getValue('icci', $arrayF) / (1 - pow(1 + getValue('icci', $arrayF), -getValue('dem', $arrayF)));
			}
        } else {
			if (getValue('ea', $array) == 'NE' || getValue('ea', $array) == 'EESP' ) {
				$res1 = ((getValue('fp', $array) * getValue('icci', $arrayF)) / (1 - pow(1 + getValue('icci', $arrayF), -getValue('dem', $arrayF)))) +
					((((ctd($array) + $ahb) - getValue('fp', $array)) * getValue('ti', $arrayF)) / (1 - pow(1 + getValue('ti', $arrayF), -getValue('dem', $arrayF))));
			} else {
				$res1 = ((getValue('fp', $array) * getValue('icci', $arrayF)) / (1 - pow(1 + getValue('icci', $arrayF), -getValue('dem', $arrayF)))) +
					((($ahb - getValue('fp', $array)) * getValue('ti', $arrayF)) / (1 - pow(1 + getValue('ti', $arrayF), -getValue('dem', $arrayF))));
			}
        }
    }

    return round($res1, 2);
}

function caci15($array, $arrayF)
{
    $cb = cb($array);
    $ahb = ahb($array, $arrayF);
    $res1 = 0;
    $res2 = ($cb * getValue('ti', $arrayF)) / (1 - pow((1 + getValue('ti', $arrayF)), -getValue('deb', $arrayF)));

    if ((getValue('fp', $array) - $ahb) > $cb) {
        $res3 = ($cb * getValue('icci', $arrayF)) / (1 - pow(1 + getValue('icci', $arrayF), -getValue('deb', $arrayF)));
    } else {
        $res4 = ($cb - (getValue('fp', $array) - $ahb)) * getValue('ti', $arrayF) / (1 - pow(1 + getValue('ti', $arrayF), -getValue('deb', $arrayF)));
        $res3 = ((getValue('fp', $array) - $ahb) * getValue('icci', $arrayF) / (1 - pow(1 + getValue('icci', $arrayF), -getValue('deb', $arrayF)))) + $res4;
    }

    if (getValue('financement', $array) == 'Emprunt') {
        $res1 += $res2;
    } else {
        if ($ahb < getValue('fp', $array)) {
            $res1 += $res3;
        } else {
            $res1 = (($cb * getValue('ti', $arrayF)) / (1 - pow(1 + getValue('ti', $arrayF), -getValue('deb', $arrayF))));
        }
    }
    return round($res1, 2);
}

function cacitot($array, $arrayF)
{
    return caci15($array, $arrayF) + caciav7($array, $arrayF);
}

function racan1($array)
{
    if (getValue('naissage', $array) == 'Non')
        return cte($array);
    else
        return 0;
}

function racan2Plus($array)
{
    if (getValue('naissage', $array) == 'Non')
        return cte($array) * getValue('nbcy', $array);
    else
        return 0;
}

function rac($array)
{
    if (getValue('naissage', $array) == 'Oui')
        return (getValue('pat', $array) - getValue('prt', $array)) * getValue('nbt', $array) * getValue('tauxrenouv', $array) / 100;
    else
        return 0;
}

function somlacpx($array)
{
    $ret = 0;

    if (getValue('naissage', $array) == 'Oui')
        $ret = getValue('cjal', $array) * getValue('aps', $array) * getValue('nbcy', $array) * getValue('pal', $array) * (getValue('nbt', $array)) +
            getValue('cjag', $array) * getValue('nbcy', $array) * 7 * getValue('pal', $array) * getValue('nbt', $array);

    return $ret;
}

function somgespx($array)
{
    $ret = 0;

    if (getValue('naissage', $array) == 'Oui')
        $ret = getValue('cjag', $array) * (365 - (getValue('nbcy', $array) * (getValue('aps', $array) + 7))) * getValue('pag', $array) * getValue('nbt', $array) + (getValue('nbv', $array) * 365 * getValue('pag', $array));

    return $ret;
}

function sompclpx($array, $arrayF)
{
    $ret = 0;
	$pase = 0;
    $nbpoe = nbpoe($array);
	
	if (getValue('commercialisation', $array) == 'Filière porc en plein air')
		$pase = getValue('pasepp', $arrayF);
	else
		$pase = getValue('pasebio', $arrayF);
		
    if (getValue('naissage', $array) == 'Oui') {
        if (getValue('dpn', $array) == 'VTPE') {
			$ret = getValue('nbps', $array) * getValue('nbt', $array) * getValue('icmoins25', $arrayF) * 
			(getValue('pdvp', $array) - getValue('pdps', $array)) * $pase;
        } else if (getValue('dpn', $array) == 'EPCF') {
            $ret = getValue('nbps', $array) * getValue('nbt', $array) * getValue('icmoins25', $arrayF) * (getValue('pdtpe', $arrayF) - getValue('pdps', $array)) * $pase;
        } else {
            $ret = ((getValue('nbps', $array) * getValue('nbt', $array)) - ($nbpoe * getValue('nbcy', $array))) * getValue('icmoins25', $arrayF) * (getValue('pdvp', $array) - getValue('pdps', $array)) * $pase + $nbpoe * getValue('nbcy', $array) * getValue('icmoins25', $arrayF) * (getValue('pdtpe', $arrayF) - getValue('pdps', $array)) * $pase;
		}
    }

    return $ret;
}


function somengpx($array, $arrayF)
{
    $ret = 0;
    $nbpoe = nbpoe($array);

    if (getValue('icde25a125', $array) == "Elevé") {
        $icde25a125 = 3.3;
    } elseif (getValue('icde25a125', $array) == "Moyen") {
        $icde25a125 = 3.5;
    } else {
        $icde25a125 = 3.7;
    }


    if (getValue('naissage', $array) == 'Oui') {
        if (getValue('dpn', $array) == 'VTPE') {
            return $ret;
        } else if (getValue('dpn', $array) == 'VPPE') {
            if (getValue('paf', $array) == 0)
                return $nbpoe * getValue('nbcy', $array) * (getValue('pda', $array) - getValue('pdtpe', $arrayF)) * $icde25a125 * getValue('pac', $array);
            else
                return $nbpoe * getValue('nbcy', $array) * (getValue('pdca', $arrayF) - getValue('pdtpe', $arrayF)) * getValue('icmoins25', $arrayF) * getValue('pac', $array) +
                $nbpoe * getValue('nbcy', $array) * (getValue('pda', $array) - getValue('pdca', $arrayF)) * $icde25a125 * getValue('paf', $array);
        } else if (getValue('paf', $array) == 0)
            return $nbpoe * getValue('nbcy', $array) * (getValue('pda', $array) - getValue('pdtpe', $arrayF)) * $icde25a125 * getValue('pac', $array);
        else
            return $nbpoe * getValue('nbcy', $array) * (getValue('pdca', $arrayF) - getValue('pdtpe', $arrayF)) * getValue('icmoins25', $arrayF) * getValue('pac', $array) +
            $nbpoe * getValue('nbcy', $array) * (getValue('pda', $array) - getValue('pdca', $arrayF)) * $icde25a125 * getValue('paf', $array);
    } else if (getValue('paf', $array) == 0)
        return getValue('nbpe', $array) * getValue('nbcy', $array) * (getValue('pda', $array) - getValue('pdap', $arrayF)) * $icde25a125 * getValue('pac', $array);
    else
        return getValue('nbpe', $array) * getValue('nbcy', $array) * (getValue('pdca', $arrayF) - getValue('pdap', $arrayF)) * getValue('icmoins25', $arrayF) * getValue('pac', $array) +
        getValue('nbpe', $array) * getValue('nbcy', $array) * (getValue('pda', $array) - getValue('pdca', $arrayF)) * $icde25a125 * getValue('paf', $array);

    return $ret;
}

function ali($array, $arrayF)
{
    return somlacpx($array) + somgespx($array) + sompclpx($array, $arrayF) + somengpx($array, $arrayF);
}

function pai($array, $arrayF)
{
    $ret = 0;
    $NBTM = nbtm($array);
    $NBTG = nbtg($array);
    $NBPOE = nbpoe($array);

    if (getValue('hm', $array) == 'Cabanes') {
        $res2 = getValue('clmc', $arrayF);
    } else {
        $res2 = getValue('clmb', $arrayF);
    }

    if (getValue('hg', $array) == 'Cabanes') {
        $res3 = getValue('clgc', $arrayF);
    } else {
        $res3 = getValue('clgb', $arrayF);
    }

    if (getValue('hpav', $array) == 'Cabanes') {
        $res5 = getValue('clpc', $arrayF);
    } else {
        $res5 = getValue('clpb', $arrayF);
    }

    if (getValue('hpe', $array) == 'Cabanes') {
        $res6 = getValue('clec', $arrayF);
    } else {
        $res6 = getValue('cleb', $arrayF);
    }

    if (getValue('dpn', $array) == "VTPE") {
        $res4 = $NBTM * getValue('nbps', $array) / getValue('nbcy', $array) * $res5;
    } else {
        if ($engraissement == "VPPE") {
            $res4 = $NBPOE * $res6;
        } else {
            $res4 = getValue('nbt', $array) * getValue('nbps', $array) / getValue('nbcy', $array) * $res6;
        }
    }

    if (getValue('hpe', $array) == 'Cabanes') {
        $res7 = getValue('clec', $arrayF);
    } else {
        $res7 = getValue('cleb', $arrayF);
    }

    if (getValue('naissage', $array) == "Oui") {
        $res1 = ($NBTM * $res2) + ($NBTG * $res3) + $res4;
    } else {
        $res1 = $NBPOE * $res7;
    }

    return getValue('cp', $arrayF) * $res1;
}

function pra($array)
{
    return (getValue('spape', $array) + getValue('spatm', $array) + getValue('spatg', $array)) * (getValue('cf', $array) + getValue('cep', $array));
}

function eau($array, $arrayF)
{
    $nbpoe = nbpoe($array);
    if (getValue('ce', $array) == 'de distribution') {
        $ce = 0.5;
    } else {
        $ce = 1;
    }
    $ret = ((getValue('nbt', $array) * getValue('cet', $arrayF)) + (getValue('cepe', $arrayF) * $nbpoe)) * 365 * $ce / 1000;

    return $ret;
}

function ele($array, $arrayF)
{
    $ret = 0;

    if (getValue('spatg', $array) + getValue('spatm', $array) + getValue('spape', $array) > 0)
        $ret = getValue('ceec', $arrayF) * getValue('cel', $arrayF);

    $ret += getValue('nbt', $array) * getValue('nbcy', $array) * getValue('celc', $arrayF) * getValue('cel', $arrayF) +
        getValue('cec', $arrayF) * getValue('cel', $arrayF);

    return $ret;
}

function fc($array, $arrayF)
{
    $ret = 0;
    $nbpoe = nbpoe($array);

    if (getValue('commercialisation', $array) == 'Filière bio')
        $ret = getValue('fcbg', $arrayF) + ((getValue('nbt', $array) + getValue('nbv', $array)) * getValue('fcbt', $arrayF)) + (getValue('fcbe', $arrayF) * $nbpoe);

    return $ret;
}

function fsa($array, $arrayF)
{
    $ret = 0;
    $nbpoe = nbpoe($array);

    if (getValue('dpn', $array) == 'EPCF') $ret = getValue('nbt', $array) * getValue('fstf', $arrayF); else $ret = getValue('nbt', $array) * getValue('fsto', $arrayF);

    if (getValue('naissage', $array) == 'Non')
        $ret += $nbpoe * getValue('fspo', $arrayF);
    else if (getValue('dpn', $array) == 'EPCF')
        $ret += $nbpoe * getValue('fspf', $arrayF) * getValue('fspo', $arrayF);

    if (getValue('ea', $array) == 'NE')
        $ret += getValue('afs', $arrayF);
    else
        $ret += 0;

    return $ret;
}

function fv($array, $arrayF)
{
    $nbpoe = nbpoe($array);

    return ($nbpoe * getValue('fve', $arrayF)) + (getValue('nbt', $array) * getValue('fvt', $arrayF));
}

function ass($array, $arrayF)
{
    if (getValue('ea', $array) == 'NE')
        return getValue('asne', $arrayF);
    else
        return getValue('asee', $arrayF);
}

function div($array, $arrayF)
{
    $nbpoe = nbpoe($array);

    if (getValue('naissage', $array) == 'Oui')
        return getValue('cd', $arrayF) + (getValue('nbia', $arrayF) * getValue('cia', $arrayF)) * getValue('nbt', $array);
    else
        return getValue('cde', $arrayF) * $nbpoe;
}

function tot_div($array, $arrayF)
{
    return pra($array) + pai($array, $arrayF) + eau($array, $arrayF) + fc($array, $arrayF) + fsa($array, $arrayF)
    + fv($array, $arrayF) + getValue('mar', $array) + ass($array, $arrayF) + div($array, $arrayF) + ele($array, $arrayF);
}

function fft($array, $arrayF)
{
    if (getValue('naissage', $array) == 'Oui')
        return rac($array, $arrayF) + ali($array, $arrayF) + tot_div($array, $arrayF);
    else
        return 0;
}

function fftan1($array, $arrayF)
{
    if (getValue('naissage', $array) == 'Non')
        return racan1($array, $arrayF) + ali($array, $arrayF) + tot_div($array, $arrayF);
    else
        return 0;
}

function fftan2Plus($array, $arrayF)
{
    if (getValue('naissage', $array) == 'Non')
        return racan2Plus($array, $arrayF) + ali($array, $arrayF) + tot_div($array, $arrayF);
    else
        return 0;
}

function vpg($array, $arrayF)
{
    $nbpoe = nbpoe($array);

    return $nbpoe * (1 - (getValue('me', $array) / 100)) * getValue('nbcy', $array) * getValue('pda', $array) * getValue('prixdevente', $array);
}

function vp($array)
{
    $ret = 0;
    $nbpoe = nbpoe($array);


    $nb = (getValue('nbt', $array) * getValue('nbps', $array) * (1 - getValue('mse', $array) / 100)) / getValue('nbcy', $array);

    if ($nbpoe >= $nb)
        $nbpoe = $nb;

    if (getValue('naissage', $array) == 'Oui' && getValue('dpn', $array) <> "EPCF") {
        //return $NBT * $NBPS / $NBCY * (1-$MSE) * $PdVP * $PVP;
        return round(((getValue('nbt', $array) * getValue('nbps', $array) * (1 - (getValue('mse', $array) / 100)))) - (round($nbpoe * getValue('nbcy', $array)))) * getValue('pvp', $array);
    } else {
        return 0;
    }
}

function rt1($array, $arrayF)
{
    $rt1 = round(vp($array) / 52 * (52 - getValue('nbsvp', $arrayF)), 0);
    if (getValue('naissage', $array) == 'Non') {
        $rt1 += vpg($array, $arrayF);
    }
    return $rt1;
}

function rtAp1($array, $arrayF)
{
    return round(vpg($array, $arrayF) + vp($array), 0);
}

function ch1($array, $arrayF)
{
    if (getValue('naissage', $array) == 'Oui')
        $res = fft($array, $arrayF) * 0.50;
    else
        $res = fftan1($array, $arrayF) * 0.75;

    return -round($res + caciav7($array, $arrayF) + caci15($array, $arrayF), 0);
}

function chav7($array, $arrayF)
{
    return -round(fftan2Plus($array, $arrayF) + fft($array, $arrayF) + caciav7($array, $arrayF) + caci15($array, $arrayF), 0);
}

function chap7($array, $arrayF)
{
    return -round(fftan2Plus($array, $arrayF) + fft($array, $arrayF) + caci15($array, $arrayF), 0);
}

function chap15($array, $arrayF)
{
    return -round(fftan2Plus($array, $arrayF) + fft($array, $arrayF), 0);
}

function rbr1($array, $arrayF)
{
    return round(rt1($array, $arrayF) + ch1($array, $arrayF), 0);
}

function rbrav7($array, $arrayF)
{
    return round(rtAp1($array, $arrayF) + chav7($array, $arrayF), 0);
}

function rbrap7($array, $arrayF)
{
    return round(rtAp1($array, $arrayF) + chap7($array, $arrayF), 0);
}

function rbrap15($array, $arrayF)
{
    return round(rtAp1($array, $arrayF) + chap15($array, $arrayF), 0);
}

//*********************************************************************************************************

function getValue($initule_s, $array)
{
    foreach ($array as &$o) {
        if (($o->getIntitule()) == trim($initule_s)) return $o->getValeur();
    }
    // Détruit la référence sur le dernier élément
    unset($o);

    return 0;
}

?>
