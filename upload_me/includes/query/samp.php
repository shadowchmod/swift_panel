<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

class Query_Protocol_samp
{

    public function status( )
    {
        $this->p->skip( 11 );
        $this->r->add( "password", $this->p->readInt8( ) );
        $this->r->add( "num_players", $this->p->readInt8( ) );
        $this->p->skip( );
        $this->r->add( "max_players", $this->p->readInt8( ) );
        $this->p->skip( 1 );
        $this->r->add( "servername", $this->readString( ) );
        $this->r->add( "gametype", $this->readString( ) );
        $this->r->add( "map", $this->readString( ) );
    }

    public function players( )
    {
        ( $this->p->getBuffer( ) );
        $this->p->skip( 11 );
        $num_players = $this->p->readInt8( );
        $this->p->skip( );
        while ( $this->p->getLength( ) )
        {
            $l = $this->p->readInt8( );
            $this->r->addPlayer( "name", $this->p->read( $l ) );
            $this->r->addPlayer( "score", $this->p->readInt32( ) );
        }
    }

    public function modifyPacket( $packet_conf )
    {
        $addr = ( "", ( "chr", ( ".", $packet_conf['addr'] ) ) );
        $port = ( $packet_conf['port'] & 255 ).( $packet_conf['port'] >> 8 & 255 );
        $packet_conf['data'] = ( $packet_conf['data'], $addr, $port );
        return $packet_conf;
    }

    private function readString( )
    {
        $l = $this->p->readInt8( );
        $this->p->skip( 3 );
        return $this->p->read( $l );
    }

}

?>
