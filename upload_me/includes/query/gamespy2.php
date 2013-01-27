<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

class Query_Protocol_gamespy2
{

    public function status( )
    {
        $this->header( );
        while ( $this->p->getLength( ) )
        {
            $this->r->add( $this->p->readString( ), $this->p->readString( ) );
        }
    }

    public function players( )
    {
        $this->header( );
        $this->getSub( "players" );
        $this->getSub( "teams" );
    }

    private function getSub( $type )
    {
        try
        {
            $this->r->add( "num_".$type, $this->p->readInt8( ) );
        }
        catch ( Query_ParsingException $e )
        {
            return;
        }
        $varnames = array( );
        while ( $this->p->getLength( ) )
        {
            $varnames[] = ( "_", "", $this->p->readString( ) );
            if ( !( $this->p->lookAhead( ) === "\x00" ) )
            {
                continue;
            }
            $this->p->skip( );
            break;
            break;
        }
        if ( $this->p->lookAhead( ) == "\x00" )
        {
            $this->p->skip( );
        }
        else
        {
            while ( 4 < $this->p->getLength( ) )
            {
                foreach ( $varnames as $varname )
                {
                    $this->r->addSub( $type, $varname, $this->p->readString( ) );
                }
                if ( !( $this->p->lookAhead( ) === "\x00" ) )
                {
                    continue;
                }
                $this->p->skip( );
                break;
                break;
            }
        }
    }

    private function header( )
    {
        if ( $this->p->read( ) !== "\x00" )
        {
            throw new Query_ParsingException( $this->p );
        }
        $this->p->read( 4 );
        if ( $this->p->lookAhead( ) == "\x00" )
        {
            $this->p->read( );
        }
        if ( $this->p->readLast( ) !== "\x00" )
        {
            throw new Query_ParsingException( $this->p );
        }
    }

}

?>
