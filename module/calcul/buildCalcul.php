<?php
if (isset($_GET["p2"])) {
    switch ($_GET["p2"]) {
        case "error":
            include 'module/calcul/alert/alert-errorCalcul.php';
            //$list = $controleur->getAllReponseFormCalcul(session_id());
            break;
        case "success":
            include 'module/calcul/alert/alert-successCalcul.php';
            $list = $controleur->getAllReponseFormCalcul(session_id());
            break;
        case "calcul":
            $list = $controleur->getAllValueFormCalcul();

            //Valeur de retour
            $b = true;

            //Calcul du résultat économique
            $listResponse = Array();


            $serv         = "http" . (($_SERVER["HTTPS"] == "on") ? 's' : '') . "://" . $_SERVER["SERVER_NAME"] .$_SERVER['REQUEST_URI'];


            if ($controleur->chkSel($_POST['pu']) && $controleur->chkSel($_POST['ea']) && $controleur->chkSel($_POST['financement']) && $controleur->chkSel($_POST['commercialisation']) && $controleur->chkSel($_POST['naissage'])) {
                //echo 'ok1';
                array_push($listResponse, (new Reponse('pu', $_POST['pu'])));
                array_push($listResponse, (new Reponse('ea', $_POST['ea'])));
                array_push($listResponse, (new Reponse('financement', $_POST['financement'])));
                array_push($listResponse, (new Reponse('commercialisation', $_POST['commercialisation'])));
                array_push($listResponse, (new Reponse('naissage', $_POST['naissage'])));

                if ($_POST['financement'] == 'FP')
                    array_push($listResponse, (new Reponse('fp', $_POST['fp'])));

                if ($_POST['naissage'] == 'Oui') {
                    //echo 'ok2';

                    if (!is_nan($_POST['nbt']))
                        array_push($listResponse, (new Reponse('nbt', $_POST['nbt'])));
                    else {
                        header("location: " . $serv . "index.php?p=formulaire&p2=error");
                        $b = false;
                    }
                    if (!is_nan($_POST['pat']))
                        array_push($listResponse, (new Reponse('pat', $_POST['pat'])));
                    else {
                        header("location: " . $serv . "index.php?p=formulaire&p2=error");
                        $b = false;
                    }
                    if (!is_nan($_POST['nbv']))
                        array_push($listResponse, (new Reponse('nbv', $_POST['nbv'])));
                    else {
                        header("location: " . $serv . "index.php?p=formulaire&p2=error");
                        $b = false;
                    }
                    if (!is_nan($_POST['pav']))
                        array_push($listResponse, (new Reponse('pav', $_POST['pav'])));
                    else {
                        header("location: " . $serv . "index.php?p=formulaire&p2=error");
                        $b = false;
                    }
                    if (!is_nan($_POST['prt']))
                        array_push($listResponse, (new Reponse('prt', $_POST['prt'])));
                    else {
                        header("location: " . $serv . "index.php?p=formulaire&p2=error");
                        $b = false;
                    }

                    if ($controleur->chkSel($_POST['ceb']) && $controleur->chkSel($_POST['nbps']) && $controleur->chkSel($_POST['hm']) && $controleur->chkSel($_POST['pm']) && $controleur->chkSel($_POST['hg']) && $controleur->chkSel($_POST['pg']) && $controleur->chkSel($_POST['dpn'])) {
                        //echo 'ok3';

                        array_push($listResponse, (new Reponse('nbps', $_POST['nbps'])));
                        array_push($listResponse, (new Reponse('ceb', $_POST['ceb'])));

                        if (!is_nan($_POST['nbcy']))
                            array_push($listResponse, (new Reponse('nbcy', $_POST['nbcy'])));
                        else {
                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                            $b = false;
                        }
                        if (!is_nan($_POST['aps']))
                            array_push($listResponse, (new Reponse('aps', $_POST['aps'])));
                        else {
                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                            $b = false;
                        }
                        if (!is_nan($_POST['cjal']))
                            array_push($listResponse, (new Reponse('cjal', $_POST['cjal'])));
                        else {
                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                            $b = false;
                        }
                        if (!is_nan($_POST['cjag']))
                            array_push($listResponse, (new Reponse('cjag', $_POST['cjag'])));
                        else {
                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                            $b = false;
                        }
                        if (!is_nan($_POST['nbslg']))
                            array_push($listResponse, (new Reponse('nbslg', $_POST['nbslg'])));
                        else {
                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                            $b = false;
                        }
                        if (!is_nan($_POST['pal']))
                            array_push($listResponse, (new Reponse('pal', $_POST['pal'])));
                        else {
                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                            $b = false;
                        }
                        if (!is_nan($_POST['pag']))
                            array_push($listResponse, (new Reponse('pag', $_POST['pag'])));
                        else {
                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                            $b = false;
                        }
                        if (!is_nan($_POST['pase']))
                            array_push($listResponse, (new Reponse('pase', $_POST['pase'])));
                        else {
                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                            $b = false;
                        }
                        if (!is_nan($_POST['mse']))
                            array_push($listResponse, (new Reponse('mse', $_POST['mse'])));
                        else {
                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                            $b = false;
                        }

                        array_push($listResponse, (new Reponse('hm', $_POST['hm'])));
                        array_push($listResponse, (new Reponse('pm', $_POST['pm'])));
                        array_push($listResponse, (new Reponse('hg', $_POST['hg'])));
                        array_push($listResponse, (new Reponse('pg', $_POST['pg'])));

                        if ($_POST['hm'] == 'Bâtiment neuf')
                            if (!is_nan($_POST['mbnm']))
                                array_push($listResponse, (new Reponse('mbnm', $_POST['mbnm'])));
                            else {
                                header("location: " . $serv . "index.php?p=formulaire&p2=error");
                                $b = false;
                            }
                        if ($_POST['pm'] == 'Oui')
                            if (!is_nan($_POST['spatm']))
                                array_push($listResponse, (new Reponse('spatm', $_POST['spatm'])));
                            else {
                                header("location: " . $serv . "index.php?p=formulaire&p2=error");
                                $b = false;
                            }
                        if ($_POST['hg'] == 'Bâtiment neuf')
                            if (!is_nan($_POST['mbng']))
                                array_push($listResponse, (new Reponse('mbng', $_POST['mbng'])));
                            else {
                                header("location: " . $serv . "index.php?p=formulaire&p2=error");
                                $b = false;
                            }
                        if ($_POST['pg'] == 'Oui')
                            if (!is_nan($_POST['spatg']))
                                array_push($listResponse, (new Reponse('spatg', $_POST['spatg'])));
                            else {
                                header("location: " . $serv . "index.php?p=formulaire&p2=error");
                                $b = false;
                            }

                        array_push($listResponse, (new Reponse('dpn', $_POST['dpn'])));
                        array_push($listResponse, (new Reponse('hpav', $_POST['hpav'])));

                        switch ($_POST['dpn']) {
                            case 'VTPE':
                                if (!is_nan($_POST['pvp']))
                                    array_push($listResponse, (new Reponse('pvp', $_POST['pvp'])));
                                else {
                                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                                    $b = false;
                                }
                                if (!is_nan($_POST['pdvp']))
                                    array_push($listResponse, (new Reponse('pdvp', $_POST['pdvp'])));
                                else {
                                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                                    $b = false;
                                }

                                //Prend en compte celui par défault
                                array_push($listResponse, (new Reponse('pdps', $controleur->getValue("pdps", $list))));

                                if ($controleur->chkSel($_POST['hpav'])) {
                                    if ($_POST['hpav'] == 'Bâtiment neuf') {
                                        if (!is_nan($_POST['mbnpav']))
                                            array_push($listResponse, (new Reponse('mbnpav', $_POST['mbnpav'])));
                                        else {
                                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                                            $b = false;
                                        }
                                    }
                                } else {
                                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                                    $b = false;
                                }

                                break;
                            case 'VPPE':
                                if (!is_nan($_POST['pvp']))
                                    array_push($listResponse, (new Reponse('pvp', $_POST['pvp'])));
                                else {
                                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                                    $b = false;
                                }
                                if (!is_nan($_POST['pdvp']))
                                    array_push($listResponse, (new Reponse('pdvp', $_POST['pdvp'])));
                                else {
                                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                                    $b = false;
                                }

                                //Prend en compte celui par défault
                                array_push($listResponse, (new Reponse('pdps', $controleur->getValue("pdps", $list))));

                                if ($controleur->chkSel($_POST['hpav'])) {
                                    if ($_POST['hpav'] == 'Bâtiment neuf') {
                                        if (!is_nan($_POST['mbnpav']))
                                            array_push($listResponse, (new Reponse('mbnpav', $_POST['mbnpav'])));
                                        else {
                                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                                            $b = false;
                                        }
                                    }
                                } else {
                                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                                    $b = false;
                                }

                                array_push($listResponse, (new Reponse('hpav', $_POST['hpav'])));
                                break;
                            case 'EPCF':
                                if ($controleur->chkSel($_POST['hpav'])) {
                                    if ($_POST['hpav'] == 'Bâtiment neuf') {
                                        if (!is_nan($_POST['mbnpav']))
                                            array_push($listResponse, (new Reponse('mbnpav', $_POST['mbnpav'])));
                                        else {
                                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                                            $b = false;
                                        }
                                    }
                                } else {
                                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                                    $b = false;
                                }

                                array_push($listResponse, (new Reponse('hpav', $_POST['hpav'])));
                                break;
                        }
                    } else {
                        header("location: " . $serv . "index.php?p=formulaire&p2=error");
                        $b = false;
                    }
                } else
                    array_push($listResponse, (new Reponse('nbcy', $controleur->getValue("nbcy", $list))));

                //echo $_POST['dpn']."iiiiiiiiii";

                if ($_POST['naissage'] == 'Non' OR $_POST['dpn'] != 'VTPE') {
                    //echo 'ok4';
                    if ($_POST['naissage'] == 'Non') {
                        if (!is_nan($_POST['pvpa']))
                            array_push($listResponse, (new Reponse('pvp', $_POST['pvpa'])));
                        else {
                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                            $b = false;
                        }
                        if (!is_nan($_POST['pdvpa']))
                            array_push($listResponse, (new Reponse('pdvp', $_POST['pdvpa'])));
                        else {
                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                            $b = false;
                        }
                    }

                    if ($_POST['dpn'] != 'VTPE')
                        if (!is_nan($_POST['pdps']))
                            array_push($listResponse, (new Reponse('pdps', $_POST['pdps'])));
                        else {
                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                            $b = false;
                        }

                    if ($controleur->chkSel($_POST['icde25a125']) && $controleur->chkSel($_POST['hpe']) && $controleur->chkSel($_POST['pe'])) {
                        if (!is_nan($_POST['nbpe']))
                            array_push($listResponse, (new Reponse('nbpe', $_POST['nbpe'])));
                        else {
                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                            $b = false;
                        }
                        if (!is_nan($_POST['pac']))
                            array_push($listResponse, (new Reponse('pac', $_POST['pac'])));
                        else {
                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                            $b = false;
                        }
                        if (!is_nan($_POST['paf']))
                            array_push($listResponse, (new Reponse('paf', $_POST['paf'])));
                        else {
                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                            $b = false;
                        }
                        if (!is_nan($_POST['nbse']))
                            array_push($listResponse, (new Reponse('nbse', $_POST['nbse'])));
                        else {
                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                            $b = false;
                        }
                        if (!is_nan($_POST['me']))
                            array_push($listResponse, (new Reponse('me', $_POST['me'])));
                        else {
                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                            $b = false;
                        }
                        if (!is_nan($_POST['pda']))
                            array_push($listResponse, (new Reponse('pda', $_POST['pda'])));
                        else {
                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                            $b = false;
                        }
                        if (!is_nan($_POST['prixdevente']))
                            array_push($listResponse, (new Reponse('prixdevente', $_POST['prixdevente'])));
                        else {
                            header("location: " . $serv . "index.php?p=formulaire&p2=error");
                            $b = false;
                        }

                        array_push($listResponse, (new Reponse('icde25a125', $_POST['icde25a125'])));
                        array_push($listResponse, (new Reponse('pe', $_POST['pe'])));

                        if ($_POST['hpe'] == 'Bâtiment neuf')
                            if (!is_nan($_POST['mbne']))
                                array_push($listResponse, (new Reponse('mbne', $_POST['mbne'])));
                            else {
                                header("location:" . $serv . "index.php?p=formulaire&p2=error");
                                $b = false;
                            }

                        if ($_POST['pe'] == 'Oui')
                            if (!is_nan($_POST['spape']))
                                array_push($listResponse, (new Reponse('spape', $_POST['spape'])));
                            else {
                                header("location: " . $serv . "index.php?p=formulaire&p2=error");
                                $b = false;
                            }
                    } else {
                        header("location: " . $serv . "index.php?p=formulaire&p2=error");
                        $b = false;
                    }
                }

                if (!is_nan($_POST['ce']))
                    array_push($listResponse, (new Reponse('ce', $_POST['ce'])));
                else {
                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                    $b = false;
                }
                if (!is_nan($_POST['cf']))
                    array_push($listResponse, (new Reponse('cf', $_POST['cf'])));
                else {
                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                    $b = false;
                }
                if (!is_nan($_POST['cep']))
                    array_push($listResponse, (new Reponse('cep', $_POST['cep'])));
                else {
                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                    $b = false;
                }
                if (!is_nan($_POST['cmce']))
                    array_push($listResponse, (new Reponse('cmce', $_POST['cmce'])));
                else {
                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                    $b = false;
                }
                if (!is_nan($_POST['cmt']))
                    array_push($listResponse, (new Reponse('cmt', $_POST['cmt'])));
                else {
                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                    $b = false;
                }
                if (!is_nan($_POST['lt']))
                    array_push($listResponse, (new Reponse('lt', $_POST['lt'])));
                else {
                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                    $b = false;
                }
                if (!is_nan($_POST['lce']))
                    array_push($listResponse, (new Reponse('lce', $_POST['lce'])));
                else {
                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                    $b = false;
                }

                if (!is_nan($_POST['ttp']) && $_POST['ttp'] != NULL)
                    array_push($listResponse, (new Reponse('ttp', $_POST['ttp'])));
                if (!is_nan($_POST['tc']) && $_POST['tc'] != NULL)
                    array_push($listResponse, (new Reponse('tc', $_POST['tc'])));

                if (!is_nan($_POST['ttep']) && $_POST['ttep'] != NULL)
                    array_push($listResponse, (new Reponse('ttep', $_POST['ttep'])));
                if (!is_nan($_POST['tec']) && $_POST['tec'] != NULL)
                    array_push($listResponse, (new Reponse('tec', $_POST['tec'])));

                if (!is_nan($_POST['qtp']) && $_POST['qtp'] != NULL)
                    array_push($listResponse, (new Reponse('qtp', $_POST['qtp'])));
                if (!is_nan($_POST['qc']) && $_POST['qc'] != NULL)
                    array_push($listResponse, (new Reponse('qc', $_POST['qc'])));

                if (!is_nan($_POST['atp']) && $_POST['atp'] != NULL)
                    array_push($listResponse, (new Reponse('atp', $_POST['atp'])));
                if (!is_nan($_POST['ac']) && $_POST['ac'] != NULL)
                    array_push($listResponse, (new Reponse('ac', $_POST['ac'])));

                if (!is_nan($_POST['mar']))
                    array_push($listResponse, (new Reponse('mar', $_POST['mar'])));
                else {
                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                    $b = false;
                }

                if (!is_nan($_POST['mab1']))
                    array_push($listResponse, (new Reponse('mab1', $_POST['mab1'])));
                else {
                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                    $b = false;
                }
                if (!is_nan($_POST['mab2']))
                    array_push($listResponse, (new Reponse('mab2', $_POST['mab2'])));
                else {
                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                    $b = false;
                }
                if (!is_nan($_POST['mab3']))
                    array_push($listResponse, (new Reponse('mab3', $_POST['mab3'])));
                else {
                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                    $b = false;
                }
                if (!is_nan($_POST['mab4']))
                    array_push($listResponse, (new Reponse('mab4', $_POST['mab4'])));
                else {
                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                    $b = false;
                }
                if (!is_nan($_POST['mab5']))
                    array_push($listResponse, (new Reponse('mab5', $_POST['mab5'])));
                else {
                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                    $b = false;
                }
                if (!is_nan($_POST['mab']))
                    array_push($listResponse, (new Reponse('mab', $_POST['mab'])));
                else {
                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                    $b = false;
                }

                array_push($listResponse, (new Reponse('hpe', $_POST['hpe'])));
                if (!is_nan($_POST['cs']))
                    array_push($listResponse, (new Reponse('cs', $_POST['cs'])));
                else {
                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
                    $b = false;
                }
                array_push($listResponse, (new Reponse('tauxrenouv', $controleur->getValue("tauxrenouv",$list))));

                $var = "";

                if ($controleur->user("email"))
                    $var = $controleur->user("email");

                if (isset($_GET["p4"]))
                    $session_id_old = $_GET["p4"];

                if ($controleur->calculResultatEco($listResponse, $var, session_id(), $session_id_old) && $b)
                    header("location: " . $serv . "index.php?p=formulaire&p2=success&p3=resultat");
                else
                    header("location: " . $serv . "index.php?p=formulaire&p2=error");
            } else {
                header("location: " . $serv . "index.php?p=formulaire&p2=error");
                $b = false;
            }
            break;
        default:
            header('index.php?p=erreur404');
            break;
    }
}
?>
