<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

class SMTP
{

    public $SMTP_PORT = 25;
    public $CRLF = "\r\n";
    public $do_debug = NULL;
    public $do_verp = false;
    private $smtp_conn = NULL;
    private $error = NULL;
    private $helo_rply = NULL;

    public function __construct( )
    {
        $this->smtp_conn = 0;
        $this->error = null;
        $this->helo_rply = null;
        $this->do_debug = 0;
    }

    public function Connect( $host, $port = 0, $tval = 30 )
    {
        $this->error = null;
        if ( $this->connected( ) )
        {
            $this->error = array( "error" => "Already connected to a server" );
            return false;
        }
        if ( empty( $port ) )
        {
            $port = $this->SMTP_PORT;
        }
        $this->smtp_conn = ( $host, $port, $errno, $errstr, $tval );
        if ( empty( $this->smtp_conn ) )
        {
            $this->error = array(
                "error" => "Failed to connect to server",
                "errno" => $errno,
                "errstr" => $errstr
            );
            if ( 1 <= $this->do_debug )
            {
                echo "SMTP -> ERROR: ".$this->error['error'].": {$errstr} ({$errno})".$this->CRLF;
            }
            return false;
        }
        if ( ( PHP_OS, 0, 3 ) != "WIN" )
        {
            ( $this->smtp_conn, $tval, 0 );
        }
        $announce = $this->get_lines( );
        if ( 2 <= $this->do_debug )
        {
            echo "SMTP -> FROM SERVER:".$this->CRLF.$announce;
        }
        return true;
    }

    public function StartTLS( )
    {
        $this->error = null;
        if ( !$this->connected( ) )
        {
            $this->error = array( "error" => "Called StartTLS() without being connected" );
            return false;
        }
        ( $this->smtp_conn, "STARTTLS".$this->CRLF );
        $rply = $this->get_lines( );
        $code = ( $rply, 0, 3 );
        if ( 2 <= $this->do_debug )
        {
            echo "SMTP -> FROM SERVER:".$this->CRLF.$rply;
        }
        if ( $code != 220 )
        {
            $this->error = array(
                "error" => "STARTTLS not accepted from server",
                "smtp_code" => $code,
                "smtp_msg" => ( $rply, 4 )
            );
            if ( 1 <= $this->do_debug )
            {
                echo "SMTP -> ERROR: ".$this->error['error'].": ".$rply.$this->CRLF;
            }
            return false;
        }
        if ( !( $this->smtp_conn, true, STREAM_CRYPTO_METHOD_TLS_CLIENT ) )
        {
            return false;
        }
        return true;
    }

    public function Authenticate( $username, $password )
    {
        ( $this->smtp_conn, "AUTH LOGIN".$this->CRLF );
        $rply = $this->get_lines( );
        $code = ( $rply, 0, 3 );
        if ( $code != 334 )
        {
            $this->error = array(
                "error" => "AUTH not accepted from server",
                "smtp_code" => $code,
                "smtp_msg" => ( $rply, 4 )
            );
            if ( 1 <= $this->do_debug )
            {
                echo "SMTP -> ERROR: ".$this->error['error'].": ".$rply.$this->CRLF;
            }
            return false;
        }
        ( $this->smtp_conn, ( $username ).$this->CRLF );
        $rply = $this->get_lines( );
        $code = ( $rply, 0, 3 );
        if ( $code != 334 )
        {
            $this->error = array(
                "error" => "Username not accepted from server",
                "smtp_code" => $code,
                "smtp_msg" => ( $rply, 4 )
            );
            if ( 1 <= $this->do_debug )
            {
                echo "SMTP -> ERROR: ".$this->error['error'].": ".$rply.$this->CRLF;
            }
            return false;
        }
        ( $this->smtp_conn, ( $password ).$this->CRLF );
        $rply = $this->get_lines( );
        $code = ( $rply, 0, 3 );
        if ( $code != 235 )
        {
            $this->error = array(
                "error" => "Password not accepted from server",
                "smtp_code" => $code,
                "smtp_msg" => ( $rply, 4 )
            );
            if ( 1 <= $this->do_debug )
            {
                echo "SMTP -> ERROR: ".$this->error['error'].": ".$rply.$this->CRLF;
            }
            return false;
        }
        return true;
    }

    public function Connected( )
    {
        if ( !empty( $this->smtp_conn ) )
        {
            $sock_status = ( $this->smtp_conn );
            if ( $sock_status['eof'] )
            {
                if ( 1 <= $this->do_debug )
                {
                    echo "SMTP -> NOTICE:".$this->CRLF."EOF caught while checking if connected";
                }
                $this->Close( );
                return false;
            }
            return true;
        }
        return false;
    }

    public function Close( )
    {
        $this->error = null;
        $this->helo_rply = null;
        if ( !empty( $this->smtp_conn ) )
        {
            ( $this->smtp_conn );
            $this->smtp_conn = 0;
        }
    }

    public function Data( $msg_data )
    {
        $this->error = null;
        if ( !$this->connected( ) )
        {
            $this->error = array( "error" => "Called Data() without being connected" );
            return false;
        }
        ( $this->smtp_conn, "DATA".$this->CRLF );
        $rply = $this->get_lines( );
        $code = ( $rply, 0, 3 );
        if ( 2 <= $this->do_debug )
        {
            echo "SMTP -> FROM SERVER:".$this->CRLF.$rply;
        }
        if ( $code != 354 )
        {
            $this->error = array(
                "error" => "DATA command not accepted from server",
                "smtp_code" => $code,
                "smtp_msg" => ( $rply, 4 )
            );
            if ( 1 <= $this->do_debug )
            {
                echo "SMTP -> ERROR: ".$this->error['error'].": ".$rply.$this->CRLF;
            }
            return false;
        }
        $msg_data = ( "\r\n", "\n", $msg_data );
        $msg_data = ( "\r", "\n", $msg_data );
        $lines = ( "\n", $msg_data );
        $field = ( $lines[0], 0, ( $lines[0], ":" ) );
        $in_headers = false;
        if ( !empty( $field ) && !( $field, " " ) )
        {
            $in_headers = true;
        }
        $max_line_length = 998;
        while ( list( , $line ) = line )
        {
            $lines_out = null;
            if ( $line == "" && $in_headers )
            {
                $in_headers = false;
            }
            while ( $max_line_length < ( $line ) )
            {
                $pos = ( ( $line, 0, $max_line_length ), " " );
                if ( !$pos )
                {
                    $pos = $max_line_length - 1;
                    $lines_out[] = ( $line, 0, $pos );
                    $line = ( $line, $pos );
                }
                else
                {
                    $lines_out[] = ( $line, 0, $pos );
                    $line = ( $line, $pos + 1 );
                }
                if ( $in_headers )
                {
                    $line = "\t".$line;
                }
            }
            $lines_out[] = $line;
            while ( list( , $line_out ) = line_out )
            {
                if ( 0 < ( $line_out ) && ( $line_out, 0, 1 ) == "." )
                {
                    $line_out = ".".$line_out;
                }
                ( $this->smtp_conn, $line_out.$this->CRLF );
            }
        }
        ( $this->smtp_conn, $this->CRLF.".".$this->CRLF );
        $rply = $this->get_lines( );
        $code = ( $rply, 0, 3 );
        if ( 2 <= $this->do_debug )
        {
            echo "SMTP -> FROM SERVER:".$this->CRLF.$rply;
        }
        if ( $code != 250 )
        {
            $this->error = array(
                "error" => "DATA not accepted from server",
                "smtp_code" => $code,
                "smtp_msg" => ( $rply, 4 )
            );
            if ( 1 <= $this->do_debug )
            {
                echo "SMTP -> ERROR: ".$this->error['error'].": ".$rply.$this->CRLF;
            }
            return false;
        }
        return true;
    }

    public function Expand( $name )
    {
        $this->error = null;
        if ( !$this->connected( ) )
        {
            $this->error = array( "error" => "Called Expand() without being connected" );
            return false;
        }
        ( $this->smtp_conn, "EXPN ".$name.$this->CRLF );
        $rply = $this->get_lines( );
        $code = ( $rply, 0, 3 );
        if ( 2 <= $this->do_debug )
        {
            echo "SMTP -> FROM SERVER:".$this->CRLF.$rply;
        }
        if ( $code != 250 )
        {
            $this->error = array(
                "error" => "EXPN not accepted from server",
                "smtp_code" => $code,
                "smtp_msg" => ( $rply, 4 )
            );
            if ( 1 <= $this->do_debug )
            {
                echo "SMTP -> ERROR: ".$this->error['error'].": ".$rply.$this->CRLF;
            }
            return false;
        }
        $entries = ( $this->CRLF, $rply );
        while ( list( , $l ) = l )
        {
            $list[] = ( $l, 4 );
        }
        return $list;
    }

    public function Hello( $host = "" )
    {
        $this->error = null;
        if ( !$this->connected( ) )
        {
            $this->error = array( "error" => "Called Hello() without being connected" );
            return false;
        }
        if ( empty( $host ) )
        {
            $host = "localhost";
        }
        if ( !$this->SendHello( "EHLO", $host ) && !$this->SendHello( "HELO", $host ) )
        {
            return false;
        }
        return true;
    }

    private function SendHello( $hello, $host )
    {
        ( $this->smtp_conn, $hello." ".$host.$this->CRLF );
        $rply = $this->get_lines( );
        $code = ( $rply, 0, 3 );
        if ( 2 <= $this->do_debug )
        {
            echo "SMTP -> FROM SERVER: ".$this->CRLF.$rply;
        }
        if ( $code != 250 )
        {
            $this->error = array(
                "error" => $hello." not accepted from server",
                "smtp_code" => $code,
                "smtp_msg" => ( $rply, 4 )
            );
            if ( 1 <= $this->do_debug )
            {
                echo "SMTP -> ERROR: ".$this->error['error'].": ".$rply.$this->CRLF;
            }
            return false;
        }
        $this->helo_rply = $rply;
        return true;
    }

    public function Help( $keyword = "" )
    {
        $this->error = null;
        if ( !$this->connected( ) )
        {
            $this->error = array( "error" => "Called Help() without being connected" );
            return false;
        }
        $extra = "";
        if ( !empty( $keyword ) )
        {
            $extra = " ".$keyword;
        }
        ( $this->smtp_conn, "HELP".$extra.$this->CRLF );
        $rply = $this->get_lines( );
        $code = ( $rply, 0, 3 );
        if ( 2 <= $this->do_debug )
        {
            echo "SMTP -> FROM SERVER:".$this->CRLF.$rply;
        }
        if ( $code != 211 && $code != 214 )
        {
            $this->error = array(
                "error" => "HELP not accepted from server",
                "smtp_code" => $code,
                "smtp_msg" => ( $rply, 4 )
            );
            if ( 1 <= $this->do_debug )
            {
                echo "SMTP -> ERROR: ".$this->error['error'].": ".$rply.$this->CRLF;
            }
            return false;
        }
        return $rply;
    }

    public function Mail( $from )
    {
        $this->error = null;
        if ( !$this->connected( ) )
        {
            $this->error = array( "error" => "Called Mail() without being connected" );
            return false;
        }
        $useVerp = $this->do_verp ? "XVERP" : "";
        ( $this->smtp_conn, "MAIL FROM:<".$from.">".$useVerp.$this->CRLF );
        $rply = $this->get_lines( );
        $code = ( $rply, 0, 3 );
        if ( 2 <= $this->do_debug )
        {
            echo "SMTP -> FROM SERVER:".$this->CRLF.$rply;
        }
        if ( $code != 250 )
        {
            $this->error = array(
                "error" => "MAIL not accepted from server",
                "smtp_code" => $code,
                "smtp_msg" => ( $rply, 4 )
            );
            if ( 1 <= $this->do_debug )
            {
                echo "SMTP -> ERROR: ".$this->error['error'].": ".$rply.$this->CRLF;
            }
            return false;
        }
        return true;
    }

    public function Noop( )
    {
        $this->error = null;
        if ( !$this->connected( ) )
        {
            $this->error = array( "error" => "Called Noop() without being connected" );
            return false;
        }
        ( $this->smtp_conn, "NOOP".$this->CRLF );
        $rply = $this->get_lines( );
        $code = ( $rply, 0, 3 );
        if ( 2 <= $this->do_debug )
        {
            echo "SMTP -> FROM SERVER:".$this->CRLF.$rply;
        }
        if ( $code != 250 )
        {
            $this->error = array(
                "error" => "NOOP not accepted from server",
                "smtp_code" => $code,
                "smtp_msg" => ( $rply, 4 )
            );
            if ( 1 <= $this->do_debug )
            {
                echo "SMTP -> ERROR: ".$this->error['error'].": ".$rply.$this->CRLF;
            }
            return false;
        }
        return true;
    }

    public function Quit( $close_on_error = true )
    {
        $this->error = null;
        if ( !$this->connected( ) )
        {
            $this->error = array( "error" => "Called Quit() without being connected" );
            return false;
        }
        ( $this->smtp_conn, "quit".$this->CRLF );
        $byemsg = $this->get_lines( );
        if ( 2 <= $this->do_debug )
        {
            echo "SMTP -> FROM SERVER:".$this->CRLF.$byemsg;
        }
        $rval = true;
        $e = null;
        $code = ( $byemsg, 0, 3 );
        if ( $code != 221 )
        {
            $e = array(
                "error" => "SMTP server rejected quit command",
                "smtp_code" => $code,
                "smtp_rply" => ( $byemsg, 4 )
            );
            $rval = false;
            if ( 1 <= $this->do_debug )
            {
                echo "SMTP -> ERROR: ".$e['error'].": ".$byemsg.$this->CRLF;
            }
        }
        if ( $close_on_error )
        {
            $this->Close( );
        }
        return $rval;
    }

    public function Recipient( $to )
    {
        $this->error = null;
        if ( !$this->connected( ) )
        {
            $this->error = array( "error" => "Called Recipient() without being connected" );
            return false;
        }
        ( $this->smtp_conn, "RCPT TO:<".$to.">".$this->CRLF );
        $rply = $this->get_lines( );
        $code = ( $rply, 0, 3 );
        if ( 2 <= $this->do_debug )
        {
            echo "SMTP -> FROM SERVER:".$this->CRLF.$rply;
        }
        if ( $code != 250 && $code != 251 )
        {
            $this->error = array(
                "error" => "RCPT not accepted from server",
                "smtp_code" => $code,
                "smtp_msg" => ( $rply, 4 )
            );
            if ( 1 <= $this->do_debug )
            {
                echo "SMTP -> ERROR: ".$this->error['error'].": ".$rply.$this->CRLF;
            }
            return false;
        }
        return true;
    }

    public function Reset( )
    {
        $this->error = null;
        if ( !$this->connected( ) )
        {
            $this->error = array( "error" => "Called Reset() without being connected" );
            return false;
        }
        ( $this->smtp_conn, "RSET".$this->CRLF );
        $rply = $this->get_lines( );
        $code = ( $rply, 0, 3 );
        if ( 2 <= $this->do_debug )
        {
            echo "SMTP -> FROM SERVER:".$this->CRLF.$rply;
        }
        if ( $code != 250 )
        {
            $this->error = array(
                "error" => "RSET failed",
                "smtp_code" => $code,
                "smtp_msg" => ( $rply, 4 )
            );
            if ( 1 <= $this->do_debug )
            {
                echo "SMTP -> ERROR: ".$this->error['error'].": ".$rply.$this->CRLF;
            }
            return false;
        }
        return true;
    }

    public function Send( $from )
    {
        $this->error = null;
        if ( !$this->connected( ) )
        {
            $this->error = array( "error" => "Called Send() without being connected" );
            return false;
        }
        ( $this->smtp_conn, "SEND FROM:".$from.$this->CRLF );
        $rply = $this->get_lines( );
        $code = ( $rply, 0, 3 );
        if ( 2 <= $this->do_debug )
        {
            echo "SMTP -> FROM SERVER:".$this->CRLF.$rply;
        }
        if ( $code != 250 )
        {
            $this->error = array(
                "error" => "SEND not accepted from server",
                "smtp_code" => $code,
                "smtp_msg" => ( $rply, 4 )
            );
            if ( 1 <= $this->do_debug )
            {
                echo "SMTP -> ERROR: ".$this->error['error'].": ".$rply.$this->CRLF;
            }
            return false;
        }
        return true;
    }

    public function SendAndMail( $from )
    {
        $this->error = null;
        if ( !$this->connected( ) )
        {
            $this->error = array( "error" => "Called SendAndMail() without being connected" );
            return false;
        }
        ( $this->smtp_conn, "SAML FROM:".$from.$this->CRLF );
        $rply = $this->get_lines( );
        $code = ( $rply, 0, 3 );
        if ( 2 <= $this->do_debug )
        {
            echo "SMTP -> FROM SERVER:".$this->CRLF.$rply;
        }
        if ( $code != 250 )
        {
            $this->error = array(
                "error" => "SAML not accepted from server",
                "smtp_code" => $code,
                "smtp_msg" => ( $rply, 4 )
            );
            if ( 1 <= $this->do_debug )
            {
                echo "SMTP -> ERROR: ".$this->error['error'].": ".$rply.$this->CRLF;
            }
            return false;
        }
        return true;
    }

    public function SendOrMail( $from )
    {
        $this->error = null;
        if ( !$this->connected( ) )
        {
            $this->error = array( "error" => "Called SendOrMail() without being connected" );
            return false;
        }
        ( $this->smtp_conn, "SOML FROM:".$from.$this->CRLF );
        $rply = $this->get_lines( );
        $code = ( $rply, 0, 3 );
        if ( 2 <= $this->do_debug )
        {
            echo "SMTP -> FROM SERVER:".$this->CRLF.$rply;
        }
        if ( $code != 250 )
        {
            $this->error = array(
                "error" => "SOML not accepted from server",
                "smtp_code" => $code,
                "smtp_msg" => ( $rply, 4 )
            );
            if ( 1 <= $this->do_debug )
            {
                echo "SMTP -> ERROR: ".$this->error['error'].": ".$rply.$this->CRLF;
            }
            return false;
        }
        return true;
    }

    public function Turn( )
    {
        $this->error = array(
            "error" => "This method, TURN, of the SMTP "."is not implemented"
        );
        if ( 1 <= $this->do_debug )
        {
            echo "SMTP -> NOTICE: ".$this->error['error'].$this->CRLF;
        }
        return false;
    }

    public function Verify( $name )
    {
        $this->error = null;
        if ( !$this->connected( ) )
        {
            $this->error = array( "error" => "Called Verify() without being connected" );
            return false;
        }
        ( $this->smtp_conn, "VRFY ".$name.$this->CRLF );
        $rply = $this->get_lines( );
        $code = ( $rply, 0, 3 );
        if ( 2 <= $this->do_debug )
        {
            echo "SMTP -> FROM SERVER:".$this->CRLF.$rply;
        }
        if ( $code != 250 && $code != 251 )
        {
            $this->error = array(
                "error" => "VRFY failed on name '{$name}'",
                "smtp_code" => $code,
                "smtp_msg" => ( $rply, 4 )
            );
            if ( 1 <= $this->do_debug )
            {
                echo "SMTP -> ERROR: ".$this->error['error'].": ".$rply.$this->CRLF;
            }
            return false;
        }
        return $rply;
    }

    private function get_lines( )
    {
        $data = "";
        while ( $str = @( $this->smtp_conn, 515 ) )
        {
            if ( 4 <= $this->do_debug )
            {
                echo "SMTP -> get_lines(): \$data was \"{$data}\"".$this->CRLF;
                echo "SMTP -> get_lines(): \$str is \"{$str}\"".$this->CRLF;
            }
            $data .= $str;
            if ( 4 <= $this->do_debug )
            {
                echo "SMTP -> get_lines(): \$data is \"{$data}\"".$this->CRLF;
            }
            if ( !( ( $str, 3, 1 ) == " " ) )
            {
                continue;
            }
            break;
            break;
        }
        return $data;
    }

}

?>
