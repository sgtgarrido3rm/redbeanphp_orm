<?php

class Classe_Garrido
{
  var $tpl_mainfile;
  var $tpl_includefile;
  var $tpl_count;

  var $index    = Array();        // $index[{blockname}]  = {indexnumber}
  var $parent   = Array();        // $parent[{blockname}] = {parentblockname}
  var $defBlock = Array();        // empty block, just the defenition of the block
  var $content  = Array();        // slightly different structure than $block,
                                  // but than filled with content

  var $rootBlockName;
  var $currentBlock;
  var $outputContentStr;
  var $Debug;

    function Classe_Garrido( $tpl_file )
    {
        $this->tpl_mainfile   = $tpl_file;
        $this->tpl_count      = 0;
        $this->Debug = false;
    }

    function Debug( $state = true )
    {
        $this->Debug = $state;
    }

    function preparar()
    {
        $this->rootBlockName                    = '_RAIZ';
        $this->index[ $this->rootBlockName ]    = 0;
        $this->defBlock[ $this->rootBlockName ] = Array();

        $tplvar = Classe_Garrido::prepararHtml( $this->tpl_mainfile );

        $initdev["varrow"]  = 0;
        $initdev["coderow"] = 0;
        $initdev["index"]   = 0;

        Classe_Garrido::parseHtml( $tplvar, $this->rootBlockName, $initdev );
        Classe_Garrido::makeContentRoot();
        Classe_Garrido::cleanUp();
    }

    function cleanUp()
    {
        for( $i=0; $i <= $this->tpl_count; $i++ )
        {
            $tplvar = 'tpl_rawContent'. $i;
            unset( $this->{$tplvar} );
        }
    }

    function prepararHtml( $tpl_file )
    {
        $tplvar = 'tpl_rawContent'. $this->tpl_count;
        $this->{$tplvar}["content"] = @file( $tpl_file ) or die( $this->errorAlert("Classe_Garrido Erro: Não foi possível abrir [ $tpl_file ]!"));
        $this->{$tplvar}["size"]    = sizeof( $this->{$tplvar}["content"] );

        $this->tpl_count++;

        return $tplvar;
    }

    function parseHtml( $tplvar, $blockname, $initdev )
    {
        $coderow = $initdev["coderow"];
        $varrow  = $initdev["varrow"];
        $index   = $initdev["index"];

        while( $index < $this->{$tplvar}["size"] )
        {
            if( preg_match("/<!-- (INICIO|FIM|INCLUIR) BLOCO : (.+) -->/", $this->{$tplvar}["content"][$index], $regs))
            {
               //remove trailing and leading spaces
                $regs[2] = trim( $regs[2] );

                if( $regs[1] == "INCLUIR")
                {
                    if( isset( $this->tpl_includefile[ $regs[2] ]) )
                    {
                        $initdev["varrow"]  = $varrow;
                        $initdev["coderow"] = $coderow;
                        $initdev["index"]   = 0;

                        $tplvar2 = Classe_Garrido::prepararHtml( $this->tpl_includefile[ $regs[2] ] );
                        $initdev = Classe_Garrido::parseHtml( $tplvar2, $blockname, $initdev );

                        $coderow = $initdev["coderow"];
                        $varrow  = $initdev["varrow"];
                    }
                }
                else
                {
                    if( $regs[2] == $blockname )     //Fim de um bloco
                    {
                        break;                       //fim while loop
                    }
                    else                             //Início de um bloco
                    {
                       //Faz um bloco filho e avisa ao bloco pai
                        $this->defBlock[ $regs[2] ] = Array();
                        $this->defBlock[ $blockname ]["_B:". $regs[2]] = '';

                       //Ajustes
                        $this->index[ $regs[2] ]  = 0;
                        $this->parent[ $regs[2] ] = $blockname;

                       //Prepara para a chamada recursiva
                        $index++;
                        $initdev["varrow"]  = 0;
                        $initdev["coderow"] = 0;
                        $initdev["index"]   = $index;

                        $initdev = Classe_Garrido::parseHtml( $tplvar, $regs[2], $initdev );

                        $index = $initdev["index"];
                    }
                }
            }
            else                                                                           //É código e/ou var
            {
                $sstr = explode( "{", $this->{$tplvar}["content"][$index] );

                reset( $sstr );

                if (current($sstr) != '')
                {
                    $this->defBlock[$blockname]["_C:$coderow"] = current( $sstr );
                    $coderow++;
                }

                $sstrlength = sizeof( $sstr );

                for ( $i=1; $i < $sstrlength; $i++)
                {
                    next($sstr);

                    $strlength = strlen( current($sstr) );

                    if (current( $sstr ) == '')      // check for '{{', explode returns ''
                    {
                        $this->defBlock[$blockname]["_C:$coderow"] = '{';
                        $coderow++;
                    }
                    else
                    {
                        $pos = strpos( current($sstr), "}" );

                        if ( ($pos !== false) && ($pos > 0) )
                        {
                            $varname = substr( current($sstr), 0, $pos );

                            $this->defBlock[$blockname]["_V:$varrow" ] = $varname;
                            $varrow++;

                            if( ($pos + 1) != $strlength )
                            {
                                $this->defBlock[$blockname]["_C:$coderow"] = substr( current( $sstr ), ($pos + 1), ($strlength - ($pos + 1)) );
                                $coderow++;
                            }
                        }
                        else
                        {
                            $this->defBlock[$blockname]["_C:$coderow"] = '{'. substr( current( $sstr ), 0, $strlength  );
                            $coderow++;
                        }
                    }
                }
            }

            $index++;
        }

        $initdev["varrow"]  = $varrow;
        $initdev["coderow"] = $coderow;
        $initdev["index"]   = $index;

        return $initdev;
    }

    function makeContentRoot()
    {
        $this->content[ $this->rootBlockName ."_0"  ][0] = Array( $this->rootBlockName );
        $this->currentBlock = &$this->content[ $this->rootBlockName ."_0" ][0];
    }

    function atribuirInclude( $iblockname, $value )
    {
        $this->tpl_includefile["$iblockname"] = $value;
    }

    function novoBloco( $blockname )
    {
        $parent = &$this->content[ $this->parent[$blockname] ."_". $this->index[$this->parent[$blockname]] ];

        if( sizeof($parent) > 1 )
        {
            $lastitem = sizeof( $parent )-1;
        }
        else $lastitem = 0;

        if ( !isset( $parent[ $lastitem ]["_B:$blockname"] ))
        {
           //Nenhum bloco encontrado no parentblock com o nome de {$blockname}

           //Incrementa o contador e cria um novo bloco {$blockname}
            $this->index[ $blockname ] += 1;

            if (!isset( $this->content[ $blockname ."_". $this->index[ $blockname ] ] ) )
            {
                 $this->content[ $blockname ."_". $this->index[ $blockname ] ] = Array();
            }

           //Diz ao pai onde suas crianças (possíveis) são encontradas
            $parent[ $lastitem ]["_B:$blockname"] = $blockname ."_". $this->index[ $blockname ];
        }

       //Faz uma cópia da definição do bloco.
        $blocksize = sizeof( $this->content[$blockname ."_". $this->index[ $blockname ]] );

        $this->content[ $blockname ."_". $this->index[ $blockname ] ][ $blocksize ] = Array( $blockname );

       //link the current block to the block we just created
        $this->currentBlock = &$this->content[ $blockname ."_". $this->index[ $blockname ] ][ $blocksize ];
    }

    function atribuir( $varname, $value )
    {
       //filter block and varname out of $varname string in case of "blockname.varname"
       // if ( preg_match("/(.*)\.(.*)/", $varname, $regs ))

        if( sizeof( $regs = explode(".", $varname ) ) == 2 )  //this is faster then preg_match
        {
            //$blockSize = @key( end( $this->content[ $regs[1] ."_". $this->index[$regs[1]] ] ) );

            $lastitem = sizeof( $this->content[ $regs[0] ."_". $this->index[$regs[0]] ] );

            $lastitem > 1 ? $lastitem-- : $lastitem = 0;

            $block = &$this->content[ $regs[0] ."_". $this->index[ $regs[0] ] ][$lastitem];
            $varname = $regs[1];
        }
        else
        {
            $block = &$this->currentBlock;
        }

        $block["_V:$varname"] = $value;
    }


    function gotoBlock( $blockname )
    {
        if ( isset( $this->defBlock[ $blockname ] ) )
        {
           //get lastitem indexnumber
            $lastitem = sizeof( $this->content[$blockname ."_". $this->index[ $blockname ]] );

            $lastitem > 1 ? $lastitem-- : $lastitem = 0;

           //link the current block
            $this->currentBlock = &$this->content[ $blockname ."_". $this->index[ $blockname ] ][ $lastitem ];
        }
    }

    function getVarValue( $varname )
    {
       //filter block and varname out of $varname string in case of "blockname.varname"
       //if ( preg_match("/(.*)\.(.*)/", $varname, $regs ))

        if( sizeof( $regs = explode(".", $varname ) ) == 2 )  //this is faster then preg_match
        {
            $lastitem = sizeof( $this->content[ $regs[0] ."_". $this->index[$regs[0]] ] );

            $lastitem > 1 ? $lastitem-- : $lastitem = 0;

            $block = &$this->content[ $regs[0] ."_". $this->index[ $regs[0] ] ][$lastitem];
            $varname = $regs[1];
        }
        else
        {
            $block = &$this->currentBlock;
        }

        return $block["_V:$varname"];
    }

    function outputContent( $blockname, $str_out )
    {
        $numrows = sizeof( $this->content[ $blockname ] );

        for( $i=0; $i < $numrows; $i++)
        {
            $defblockname = $this->content[ $blockname ][$i][0];

            for( reset( $this->defBlock[ $defblockname ]);  $k = key( $this->defBlock[ $defblockname ]);  next( $this->defBlock[ $defblockname ] ) )
            {
                if( preg_match("/C:/", $k) )
                {
                   if( $str_out )
                   {
                       $this->outputContentStr .= $this->defBlock[ $defblockname ][$k];
                   }
                   else
                   {
                       print( $this->defBlock[ $defblockname ][$k] );
                   }
                }
                else
                if( preg_match("/V:/", $k) )
                {
                   $defValue = $this->defBlock[ $defblockname ][$k];

                   if( !isset( $this->content[ $blockname ][$i][ "_V:". $defValue ] ) )
                   {
                       if( $this->Debug )
                       {
                           $value = '{'. $this->defBlock[ $defblockname ][$k] .'}';
                       }
                       else $value = '';

                   }
                   else
                   {
                       $value = $this->content[ $blockname ][$i][ "_V:". $defValue ];
                   }

                   if( $str_out )
                   {
                       $this->outputContentStr .= $value;
                   }
                   else
                   {
                       print( $value );
                   }
                }
                else
                if ( preg_match("/B:/", $k) )
                {
                    if( isset( $this->content[ $blockname ][$i][$k] ) )
                    {
                        if( $this->content[ $blockname ][$i][$k] != '' )
                        {
                            Classe_Garrido::outputContent( $this->content[ $blockname ][$i][$k], $str_out );
                        }
                    }
                }
            }
        }
    }

    function ExibeTela()
    {
        Classe_Garrido::outputContent( $this->rootBlockName ."_0", false);
    }

    function getOutputContent()
    {
        Classe_Garrido::outputContent( $this->rootBlockName ."_0", true);

        return $this->outputContentStr;
    }

    function errorAlert( $message )
    {
        print( $message ."<br>");
    }

    function printVars()
    {
        var_dump($this->defBlock);
    }
}
?>
