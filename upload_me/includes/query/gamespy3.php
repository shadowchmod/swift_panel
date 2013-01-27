<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

class Query_Protocol_gamespy3
{

    public function status( )
    {
        $this->info( );
        while ( $this->p->getLength( ) && ( $type = $this->p->readInt8( ) ) )
        {
            if ( $type == 1 )
            {
                $this->getSub( "players" );
            }
            else if ( $type == 2 )
            {
                $this->getSub( "teams" );
            }
            else
            {
                $this->getSub( "players" );
                $this->getSub( "teams" );
            }
        }
    }

    private function info( )
    {
        while ( $this->p->getLength( ) )
        {
            $var = $this->p->readString( );
            if ( empty( $var ) )
            {
                break;
            }
            $this->r->add( $var, $this->p->readString( ) );
        }
    }

    private function getSub( $type )
    {
        while ( $this->p->getLength( ) )
        {
            $header = $this->p->readString( );
            if ( $header == "" )
            {
                break;
            }
            $this->p->skip( );
            while ( $this->p->getLength( ) )
            {
                $value = $this->p->readString( );
                if ( $value === "" )
                {
                    break;
                }
                $this->r->addSub( $type, $header, $value );
            }
        }
    }

    public function preprocess( $packets )
    {
        $result = array( );
        foreach ( $packets as $packet )
        {
            $p = new GameQ_Buffer( $packet );
            $p->skip( 14 );
            $cur_packet = $p->readInt16( );
            $result[$cur_packet] = $p->getBuffer( );
        }
        ( $result );
        $result = ( $result );
        $i = 0;
        $x = ( $result );
        while ( $i < $x - 1 )
        {
            $fst = ( $result[$i], 0, 0 - 1 );
            $snd = $result[$i + 1];
            $fstvar = ( $fst, ( $fst, "\x00" ) + 1 );
            $snd = ( $snd, ( $snd, "\x00" ) + 2 );
            $sndvar = ( $snd, 0, ( $snd, "\x00" ) );
            if ( ( $sndvar, $fstvar ) !== false )
            {
                $result[$i] = ( "#(\\x00[^\\x00]+\\x00)\$#", "\x00\x00", $result[$i] );
            }
            ++$i;
        }
        return ( "", $result );
    }

    public function parseChallenge( $packet )
    {
        $this->p->skip( 5 );
        $cc = ( integer )$this->p->readString( );
        $x = ( "H*", ( "%08X", $cc ) );
        return ( $packet, $x );
    }

}

?>
