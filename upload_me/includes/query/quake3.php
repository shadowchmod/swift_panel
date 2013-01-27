<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

class Query_Protocol_quake3
{

    public function getstatus( $header = "statusResponse" )
    {
        $this->header( $header );
        while ( $this->p->getLength( ) )
        {
            $this->r->add( $this->p->readString( "\\" ), $this->p->readStringMulti( array( "\\", "\n" ), $delimfound ) );
            if ( !( $delimfound === "\n" ) )
            {
                continue;
            }
            break;
            break;
        }
        $this->players( );
    }

    public function players( )
    {
        $count = 0;
        while ( $this->p->getLength( ) )
        {
            $this->r->addPlayer( "frags", $this->p->readString( " " ) );
            $this->r->addPlayer( "ping", $this->p->readString( " " ) );
            $del = $this->p->lookAhead( );
            if ( $del != "" && $del != "\"" )
            {
                $this->r->addPlayer( "team", $this->p->readString( " " ) );
            }
            if ( $this->p->read( ) != "\"" )
            {
                throw new Query_ParsingException( $this->p );
            }
            $this->r->addPlayer( "nick", $this->p->readString( "\"" ) );
            ++$count;
            if ( $this->p->read( ) !== "\n" )
            {
                throw new Query_ParsingException( $this->p );
            }
        }
        $this->r->add( "clients", $count );
    }

    public function getinfo( )
    {
        $this->getstatus( "infoResponse" );
    }

    private function header( $tag )
    {
        if ( $this->p->readInt32( ) !== 0 - 1 || $this->p->read( ( $tag ) ) !== $tag || $this->p->read( 2 ) !== "\n\\" )
        {
            throw new Query_ParsingException( $this->p );
        }
    }

}

?>
