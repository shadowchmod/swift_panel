<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

class Query_Protocol_quake2
{

    public function status( )
    {
        $this->header( );
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
        if ( 2 < $this->p->getLength( ) )
        {
            $this->players( );
        }
    }

    public function players( )
    {
        while ( $this->p->getLength( ) )
        {
            $this->r->addPlayer( "frags", $this->p->readString( " " ) );
            $this->r->addPlayer( "ping", $this->p->readString( " " ) );
            $this->r->addPlayer( "nick", $this->readQuoteString( ) );
            $del = $this->p->read( );
            if ( $del == " " )
            {
                $this->r->addPlayer( "address", $this->readQuoteString( ) );
                $del = $this->p->read( );
            }
            if ( $del !== "\n" )
            {
                throw new Query_ParsingException( $this->p );
            }
        }
    }

    private function readQuoteString( )
    {
        if ( $this->p->read( ) !== "\"" )
        {
            throw new Query_ParsingException( $this->p );
        }
        return $this->p->readString( "\"" );
    }

    private function header( )
    {
        if ( $this->p->readInt32( ) !== 0 - 1 )
        {
            throw new Query_ParsingException( $this->p );
        }
        $this->p->readString( "\\" );
    }

}

?>
