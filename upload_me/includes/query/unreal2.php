<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

class Query_Protocol_unreal2
{

    public function players( )
    {
        $this->header( "\x02" );
        while ( $this->p->getLength( ) )
        {
            $id = $this->p->readInt32( );
            if ( $id === 0 )
            {
                break;
            }
            $this->r->addPlayer( "id", $id );
            $this->r->addPlayer( "name", $this->_readUnrealString( ) );
            $this->r->addPlayer( "ping", $this->p->readInt32( ) );
            $this->r->addPlayer( "score", $this->p->readInt32( ) );
            $this->p->skip( 4 );
        }
    }

    public function rules( )
    {
        $this->header( "\x01" );
        $i = 0 - 1;
        while ( $this->p->getLength( ) )
        {
            $key = $this->p->readPascalString( 1 );
            if ( $key === "Mutator" )
            {
                $key .= ++$i;
            }
            $this->r->add( $key, $this->p->readPascalString( 1 ) );
        }
    }

    public function status( )
    {
        $this->header( "\x00" );
        $this->r->add( "serverid", $this->p->readInt32( ) );
        $this->r->add( "serverip", $this->p->readPascalString( 1 ) );
        $this->r->add( "gameport", $this->p->readInt32( ) );
        $this->r->add( "queryport", $this->p->readInt32( ) );
        $this->r->add( "servername", $this->p->readPascalString( 1 ) );
        $this->r->add( "mapname", $this->p->readPascalString( 1 ) );
        $this->r->add( "gametype", $this->p->readPascalString( 1 ) );
        $this->r->add( "playercount", $this->p->readInt32( ) );
        $this->r->add( "maxplayers", $this->p->readInt32( ) );
        $this->r->add( "ping", $this->p->readInt32( ) );
        if ( 6 < $this->p->getLength( ) )
        {
            $this->r->add( "flags", $this->p->readInt32( ) );
            $this->r->add( "skill", $this->p->readInt16( ) );
        }
    }

    private function _readUnrealString( )
    {
        if ( ( $this->p->lookAhead( 1 ) ) < 129 )
        {
            return $this->p->readPascalString( 2, true );
        }
        $length = ( $this->p->readInt8( ) - 128 ) * 2 - 3;
        $encstr = $this->p->read( $length );
        $this->p->skip( 3 );
        $encstr = ( "~\\x5e\\0\\x23\\0..~s", "", $encstr );
        $str = "";
        $i = 0;
        $ii = ( $encstr );
        while ( $i < $ii )
        {
            $str .= $encstr[$i];
            $i += 2;
        }
        return $str;
    }

    private function header( $char )
    {
        $this->p->skip( 4 );
        if ( $this->p->read( ) !== $char )
        {
            throw new Query_ParsingException( $this->p );
        }
    }

    public function preprocess( $packets )
    {
        $i = 1;
        $ii = ( $packets );
        while ( $i < $ii )
        {
            $packets[$i] = ( $packets[$i], 5 );
            ++$i;
        }
        return ( "", $packets );
    }

}

?>
