<?php

class Nfe extends model {

    public function emitirNFE($cNF, $destinatario, $prods, $fatinfo) {
        $nfe = new \NFePHP\NFe\MakeNFe();
        $nfeTools = new \NFePHP\NFe\ToolsNFe("nfe/files/config.json");

        //Dados da NFe - infNFe
        $cUF = $nfeTools->aConfig['cUF']; //codigo numerico do estado
        $natOp = 'Venda de Produto'; //natureza da operaÃ§Ã£o
        $indPag = '0'; //0=Pagamento Ã  vista; 1=Pagamento a prazo; 2=Outros
        $mod = '55'; //modelo da NFe 55 ou 65 essa Ãºltima NFCe
        $serie = '1'; //serie da NFe
        $nNF = $cNF; // numero da NFe
        $dhEmi = date("Y-m-d\TH:i:sP"); // Data de emissÃ£o
        $dhSaiEnt = date("Y-m-d\TH:i:sP"); //Data de entrada/saida
        $tpNF = '1'; // 0=entrada; 1=saida
        $idDest = '1'; //1=OperaÃ§Ã£o interna; 2=OperaÃ§Ã£o interestadual; 3=OperaÃ§Ã£o com exterior.
        $cMunFG = $nfeTools->aConfig['cMun']; // CÃ³digo do MunicÃ­pio
        $tpImp = '1'; //0=Sem geraÃ§Ã£o de DANFE; 1=DANFE normal, Retrato; 2=DANFE normal, Paisagem; 3=DANFE Simplificado; 4=DANFE NFC-e; 5=DANFE NFC-e em mensagem eletrÃ´nica
        $tpEmis = '1'; //1=EmissÃ£o normal (nÃ£o em contingÃªncia);
        //2=ContingÃªncia FS-IA, com impressÃ£o do DANFE em formulÃ¡rio de seguranÃ§a;
        //3=ContingÃªncia SCAN (Sistema de ContingÃªncia do Ambiente Nacional);
        //4=ContingÃªncia DPEC (DeclaraÃ§Ã£o PrÃ©via da EmissÃ£o em ContingÃªncia);
        //5=ContingÃªncia FS-DA, com impressÃ£o do DANFE em formulÃ¡rio de seguranÃ§a;
        //6=ContingÃªncia SVC-AN (SEFAZ Virtual de ContingÃªncia do AN);
        //7=ContingÃªncia SVC-RS (SEFAZ Virtual de ContingÃªncia do RS);
        //9=ContingÃªncia off-line da NFC-e (as demais opÃ§Ãµes de contingÃªncia sÃ£o vÃ¡lidas tambÃ©m para a NFC-e);
        //Nota: Para a NFC-e somente estÃ£o disponÃ­veis e sÃ£o vÃ¡lidas as opÃ§Ãµes de contingÃªncia 5 e 9.
        $tpAmb = $nfeTools->aConfig['tpAmb']; //1=ProduÃ§Ã£o; 2=HomologaÃ§Ã£o
        $finNFe = '1'; //1=NF-e normal; 2=NF-e complementar; 3=NF-e de ajuste; 4=DevoluÃ§Ã£o/Retorno.
        $indFinal = '0'; //0=Normal; 1=Consumidor final;
        $indPres = '2'; //0=NÃ£o se aplica (por exemplo, Nota Fiscal complementar ou de ajuste);
        //1=OperaÃ§Ã£o presencial;
        //2=OperaÃ§Ã£o nÃ£o presencial, pela Internet;
        //3=OperaÃ§Ã£o nÃ£o presencial, Teleatendimento;
        //4=NFC-e em operaÃ§Ã£o com entrega a domicÃ­lio;
        //9=OperaÃ§Ã£o nÃ£o presencial, outros.
        $procEmi = '0'; //0=EmissÃ£o de NF-e com aplicativo do contribuinte;
        //1=EmissÃ£o de NF-e avulsa pelo Fisco;
        //2=EmissÃ£o de NF-e avulsa, pelo contribuinte com seu certificado digital, atravÃ©s do site do Fisco;
        //3=EmissÃ£o NF-e pelo contribuinte com aplicativo fornecido pelo Fisco.
        $verProc = $nfeTools->aConfig['vApp']; //versÃ£o do aplicativo emissor
        $dhCont = ''; //entrada em contingÃªncia AAAA-MM-DDThh:mm:ssTZD
        $xJust = ''; //Justificativa da entrada em contingÃªncia
        $cnpj = $nfeTools->aConfig['cnpj']; // CNPJ do emitente
        //Numero e versÃ£o da NFe (infNFe)
        $ano = date('y', strtotime($dhEmi));
        $mes = date('m', strtotime($dhEmi));

        $chave = $nfe->montaChave($cUF, $ano, $mes, $cnpj, $mod, $serie, $nNF, $tpEmis, $nNF);
        $versao = $nfeTools->aConfig['nfeVersao'];
        $resp = $nfe->taginfNFe($chave, $versao);

        $cDV = substr($chave, -1); //Digito Verificador da Chave de Acesso da NF-e, o DV Ã© calculado com a aplicaÃ§Ã£o do algoritmo mÃ³dulo 11 (base 2,9) da Chave de Acesso.
        //tag IDE
        $resp = $nfe->tagide($cUF, $nNF, $natOp, $indPag, $mod, $serie, $nNF, $dhEmi, $dhSaiEnt, $tpNF, $idDest, $cMunFG, $tpImp, $tpEmis, $cDV, $tpAmb, $finNFe, $indFinal, $indPres, $procEmi, $verProc, $dhCont, $xJust);

        //Dados do emitente
        $CPF = ''; // Para Emitente CPF
        $xNome = $nfeTools->aConfig['razaosocial'];
        $xFant = $nfeTools->aConfig['nomefantasia'];
        $IE = $nfeTools->aConfig['ie']; // InscriÃ§Ã£o Estadual
        $IEST = $nfeTools->aConfig['iest']; // IE do Substituti TributÃ¡rio
        $IM = $nfeTools->aConfig['im']; // InscriÃ§Ã£o Municipal
        $CNAE = $nfeTools->aConfig['cnae']; // CNAE Fiscal
        $CRT = $nfeTools->aConfig['regime']; // CRT (CÃ³digo de Regime TributÃ¡rio), 1=simples nacional
        $resp = $nfe->tagemit($cnpj, $CPF, $xNome, $xFant, $IE, $IEST, $IM, $CNAE, $CRT);

        //endereÃ§o do emitente
        $xLgr = $nfeTools->aConfig['xLgr'];
        $nro = $nfeTools->aConfig['nro'];
        $xCpl = $nfeTools->aConfig['xCpl'];
        $xBairro = $nfeTools->aConfig['xBairro'];
        $cMun = $nfeTools->aConfig['cMun'];
        $xMun = $nfeTools->aConfig['xMun'];
        $UF = $nfeTools->aConfig['UF'];
        $CEP = $nfeTools->aConfig['CEP'];
        $cPais = $nfeTools->aConfig['cPais'];
        $xPais = $nfeTools->aConfig['xPais'];
        $fone = $nfeTools->aConfig['fone'];
        $resp = $nfe->tagenderEmit($xLgr, $nro, $xCpl, $xBairro, $cMun, $xMun, $UF, $CEP, $cPais, $xPais, $fone);

        //destinatário
        $CNPJ = $destinatario['cnpj'];
        $CPF = $destinatario['cpf'];
        $idEstrangeiro = $destinatario['idestrangeiro'];
        $xNome = $destinatario['nome']; // Nome/RazÃ£o Social
        $email = $destinatario['email'];
        $indIEDest = $destinatario['iedest']; // Indica se tem IE (vazio ou 1)
        $IE = $destinatario['ie']; // Insc. Estadual
        $ISUF = $destinatario['isuf']; // Insc. SUFRAMA
        $IM = $destinatario['im']; // Insc. Municipal
        $resp = $nfe->tagdest($CNPJ, $CPF, $idEstrangeiro, $xNome, $indIEDest, $IE, $ISUF, $IM, $email);
        //EndereÃ§o do destinatÃ¡rio
        $xLgr = $destinatario['end']['logradouro'];
        $nro = $destinatario['end']['numero'];
        $xCpl = $destinatario['end']['complemento'];
        $xBairro = $destinatario['end']['bairro'];
        $xMun = $destinatario['end']['mu'];
        $UF = $destinatario['end']['uf'];
        $CEP = $destinatario['end']['cep'];
        $xPais = $destinatario['end']['pais'];
        $fone = $destinatario['end']['fone'];
        $cMun = $destinatario['end']['cmu']; // CÃ³digo do Municipio
        $cPais = $destinatario['end']['cpais']; // CÃ³digo do PaÃ­s
        $resp = $nfe->tagenderDest($xLgr, $nro, $xCpl, $xBairro, $cMun, $xMun, $UF, $CEP, $cPais, $xPais, $fone);

        // InicializaÃ§Ã£o de vÃ¡riaveis
        $vBC = 0;
        $vICMSDeson = 0;
        $vProd = 0;
        $vFrete = 0;
        $vSeg = 0;
        $vDesc = 0;
        $vOutro = 0;
        $vII = 0;
        $vIPI = 0;
        $vIOF = 0;
        $vPIS = 0;
        $vCOFINS = 0;
        $vICMS = 0;
        $vBCST = 0;
        $vST = 0;
        $vISS = 0;

        $nItem = 1;
        foreach ($prods as $prod) {

            $cProd = $prod['cProd']; // CÃ³digo do Produto
            $cEAN = $prod['cEAN']; // CÃ³digo de Barras (EAN)
            $xProd = $prod['xProd']; // DescriÃ§Ã£o do Produto
            $NCM = $prod['NCM']; // CÃ³digo NCM (Nomenclatura Comum do MERCOSUL)
            $EXTIPI = $prod['EXTIPI']; // CÃ³digo de excessÃ£o do NCM
            $CFOP = $prod['CFOP']; // CÃ³digo Fiscal de OperaÃ§Ãµes e PrestaÃ§Ãµes
            $uCom = $prod['uCom']; // Unidade Comercial do produto
            $qCom = $prod['qCom']; // Quantidade
            $vUnCom = $prod['vUnCom']; // Valor UnitÃ¡rio
            $vProd += $prod['vProd']; // Valor do Produto
            $cEANTrib = $prod['cEANTrib']; // CÃ³digo de Barra TributÃ¡vel
            $uTrib = $prod['uTrib']; // Unidade TributÃ¡vel
            $qTrib = $prod['qTrib']; // Quantidade TributÃ¡vel
            $vUnTrib = $prod['vUnTrib']; // Valor UnitÃ¡rio de tributaÃ§Ã£o
            $vFrete += $prod['vFrete']; // Valor Total do Frete
            $vSeg += $prod['vSeg']; // Valor Total do Seguro
            $vDesc += $prod['vDesc']; // Valor do Desconto
            $vOutro += $prod['vOutro']; // Outras Despesas
            $indTot = $prod['indTot']; // Indica se valor do Item (vProd) entra no valor total da NF-e. As vezes Ã© um brinde
            $xPed = $prod['xPed']; // NÃºmero do Pedido de Compra
            $nItemPed = $prod['nItemPed']; // Item do Pedido de Compra
            $nFCI = $prod['nFCI']; // NÃºmero de controle da FCI - ImportaÃ§Ã£o
            $vBC += $prod['bc']; // Base de cÃ¡lculo
            // Adiciona o produto na nota
            $nfe->tagprod($nItem, $cProd, $cEAN, $xProd, $NCM, $EXTIPI, $CFOP, $uCom, $qCom, $vUnCom, $prod['vProd'], $cEANTrib, $uTrib, $qTrib, $vUnTrib, $prod['vFrete'], $prod['vSeg'], $prod['vDesc'], $prod['vOutro'], $indTot, $xPed, $nItemPed, $nFCI);

            // Imposto Total deste produto
            $vTotTrib = $prod['impostoTotal']; // ICMS + IPI + PIS + COFINS, etc...
            $nfe->tagimposto($nItem, $vTotTrib);

            // ICMS
            $vICMS += $prod['icms'];
            //$nfe->tagICMS(...);
            // IPI
            $vIPI += $prod['ipi'];
            //$nfe->tagIPI(...);
            // PIS
            $vPIS += $prod['pis'];
            //$nfe->tagPIS(...);
            // CONFINS
            $vCOFINS += $prod['cofins'];
            //$nfe->tagCOFINS(...);

            $nItem++;
        }

        // Valor da NF
        $vNF = number_format($vProd - $vDesc - $vICMSDeson + $vST + $vFrete + $vSeg + $vOutro + $vII + $vIPI, 2, '.', '');

        // Valor Total TributÃ¡vel
        $vTotTrib = number_format($vICMS + $vST + $vII + $vIPI + $vPIS + $vCOFINS + $vIOF + $vISS, 2, '.', '');

        // Grupos Totais
        $nfe->tagICMSTot($vBC, $vICMS, $vICMSDeson, $vBCST, $vST, $vProd, $vFrete, $vSeg, $vDesc, $vII, $vIPI, $vPIS, $vCOFINS, $vOutro, $vNF, $vTotTrib);

        // Frete
        $modFrete = '9'; //0=Por conta do emitente; 1=Por conta do destinatÃ¡rio/remetente; 2=Por conta de terceiros; 9=Sem Frete;
        $nfe->tagtransp($modFrete);

        // Dados da fatura
        $nFat = $fatinfo['nfat']; // NÃºmero da Fatura
        $vOrig = $fatinfo['vorig']; // Valor original da fatura
        $vDesc = $fatinfo['vdesc']; // Valor do desconto
        $vLiq = $fatinfo['nfat']; // Valor LÃ­quido
        $nfe->tagfat($nFat, $vOrig, $vDesc, $vLiq);

        // Monta a NF-e e retorna o resultado
        $resp = $nfe->montaNFe();
        if ($resp === true) {
            $xml = $nfe->getXML();

            // Assina o XML
            $xml = $nfeTools->assina($xml);

            // Valida o XML
            $v = $nfeTools->validarXml($xml);

            if ($v == false) {
                foreach ($nfeTools->errors as $erro) {
                    if (is_array($erro)) {
                        foreach ($erro as $er) {
                            echo $er . "<br/>";
                        }
                    } else {
                        echo $erro . "<br/>";
                    }
                }

                exit;
            }

            $idLote = '';
            $indSinc = '0'; // 0=assíncrono, 1=síncrono
            $flagZip = false;
            $resposta = array();

            // Envia para o SEFAZ
            $nfeTools->sefazEnviaLote($xml, $tpAmb, $idLote, $resposta, $indSinc, $flagZip);

            // Consulta o RECIBO
            $protXML = $nfeTools->sefazConsultaRecibo($resposta['nRec'], $tpAmb);

            // Chave aleatÃ³ria para o XML/PDF
            $chave = md5(time() . rand(0, 9999));
            $xmlName = $chave . '.xml';
            $danfeName = $chave . '.pdf';

            // Salva os arquivos temporÃ¡rio e validado
            $pathNFefile = "nfe/files/nfe/validadas/" . $xmlName;
            $pathProtfile = "nfe/files/nfe/temp/" . $xmlName;
            $pathDanfeFile = "nfe/files/nfe/danfe/" . $danfeName;
            file_put_contents($pathNFefile, $xml);
            file_put_contents($pathProtfile, $protXML);

            // Adiciona o Protocolo
            $nfeTools->addProtocolo($pathNFefile, $pathProtfile, true);

            // Gera o DANFE
            $docxml = NFePHP\Common\Files\FilesFolders::readFile($pathProtfile);

            $docFormat = $nfeTools->aConfig['aDocFormat']->format;
            $docPaper = $nfeTools->aConfig['aDocFormat']->paper;
            $docLogo = $nfeTools->aConfig['aDocFormat']->pathLogoFile;

            $danfe = new NFePHP\Extras\Danfe($docxml, $docFormat, $docPaper, $docLogo);
            $danfe->montaDANFE();
            $danfe->printDANFE($pathDanfeFile, "F");

            return $chave;
        } else {
            foreach ($nfe->erros as $erro) {
                echo $erro['tag'] . ' - ' . $erro['desc'] . "<br/>";
            }
        }
    }

}
