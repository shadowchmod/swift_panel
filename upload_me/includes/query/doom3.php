<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

class Query_Protocol_doom3
{

    public function getinfo( )
    {
        if ( $this->p->readInt16( ) !== 65535 || $this->p->readString( ) !== "infoResponse" )
        {
            throw new Query_ParsingException( $this->p );
        }
        $this->r->add( "version", $this->p->readInt8( ).".".$this->p->readInt8( ) );
        while ( $this->p->getLength( ) )
        {
            $var = $this->p->readString( );
            $val = $this->p->readString( );
            if ( empty( $var ) && empty( $val ) )
            {
                break;
            }
            $this->r->add( $var, $val );
        }
        $this->players( );
    }

    public function players( )
    {
        while ( ( $id = $this->p->readInt8( ) ) != 32 )
        {
            $this->r->addPlayer( "id", $id );
            $this->r->addPlayer( "ping", $this->p->readInt16( ) );
            $this->r->addPlayer( "rate", $this->p->readInt32( ) );
            $this->r->addPlayer( "name", $this->p->readString( ) );
        }
    }

}

?>
