<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

class Query_Protocol_gamespy
{

    public function status( )
    {
        $this->header( );
        while ( $this->p->getLength( ) )
        {
            $key = $this->p->readString( "\\" );
            if ( $key == "final" )
            {
                break;
            }
            $suffix = ( $key, "_" );
            if ( $suffix === false || !( ( $key, $suffix + 1 ) ) )
            {
                $this->r->add( $key, $this->p->readString( "\\" ) );
            }
            else
            {
                $this->r->addPlayer( ( $key, 0, $suffix ), $this->p->readString( "\\" ) );
            }
        }
    }

    public function players( )
    {
        $this->status( );
    }

    public function basic( )
    {
        $this->status( );
    }

    public function info( )
    {
        $this->status( );
    }

    public function preprocess( $packets )
    {
        if ( ( $packets ) == 1 )
        {
            return $packets[0];
        }
        $newpackets = array( );
        foreach ( $packets as $packet )
        {
            ( "#^(.*)\\\\queryid\\\\([^\\\\]+)(\\\\|\$)#", $packet, $matches );
            if ( !isset( $matches[1] ) || !isset( $matches[2] ) )
            {
                throw new Query_ParsingException( );
            }
            $newpackets[$matches[2]] = $matches[1];
        }
        ( $newpackets );
        $newpackets = ( $newpackets );
        return ( "", $newpackets );
    }

    private function header( )
    {
        if ( $this->p->read( ) !== "\\" )
        {
            throw new Query_ParsingException( $this->p );
        }
    }

}

?>
