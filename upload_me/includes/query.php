<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

class Query
{

    private $prot = array( );
    private $servers = array( );
    private $filters = array( );
    private $options = array( );
    private $cfg = NULL;
    private $comm = NULL;

    public function __construct( )
    {
        $this->setOption( "timeout", 200 );
        $this->setOption( "raw", false );
        $this->setOption( "debug", false );
        $this->setOption( "sock_count", 64 );
        $this->setOption( "sock_start", 0 );
        $this->cfg = new Query_Config( );
        $this->comm = new Query_Communicate( );
        $this->filters['normalise'] = new Query_Filter_normalise( );
    }

    public function addServer( $id, $server )
    {
        if ( !( $server ) || ( $server ) < 2 )
        {
            return false;
        }
        $game = ( $server );
        $addr = ( $server );
        $port = ( $server );
        $raddr = $this->comm->getIp( $addr );
        if ( $raddr === false )
        {
            return false;
        }
        $this->servers[$id] = $this->cfg->getGame( $game, $raddr, $port );
        return true;
    }

    public function addServers( $servers )
    {
        $result = true;
        foreach ( $servers as $id => $server )
        {
            $result = $result && $this->addServer( $id, $server );
        }
        return $result;
    }

    public function getOption( $var )
    {
        return isset( $this->options[$var] ) ? $this->options[$var] : null;
    }

    public function setOption( $var, $value )
    {
        $this->options[$var] = $value;
    }

    public function removeFilter( $name )
    {
        unset( $this->filters[$name] );
    }

    public function requestData( )
    {
        $timeout = $this->getOption( "timeout" );
        $raw = $this->getOption( "raw" );
        $sock_start = $this->getOption( "sock_start" );
        $sock_count = $this->getOption( "sock_count" );
        $data = array( );
        $packs = $this->getPackets( $this->servers );
        $packs = $this->modifyPackets( $packs );
        $i = 0;
        while ( TRUE )
        {
            $packets = ( $packs, $i, $sock_count );
            if ( empty( $packets ) )
            {
                break;
            }
            $packets = $this->comm->query( $packets, $timeout, "challenge", $sock_start );
            $packets = $this->processChallengeResponses( $packets );
            $packets = $this->comm->query( $packets, $timeout, "data", $sock_start );
            $data = ( $data, $packets );
            $i += $sock_count;
        }
        if ( $raw )
        {
            return $this->processRaw( $data, $this->servers );
        }
        $data = $this->processResponses( $data, $this->servers );
        return $this->filterResponses( $data );
    }

    public function clearServers( )
    {
        $this->servers = array( );
    }

    private function filterResponses( $responses )
    {
        foreach ( $responses as $key => $response )
        {
            foreach ( $this->filters as $filter )
            {
                $response = $filter->filter( $response, $this->servers[$key] );
            }
        }
        return $responses;
    }

    private function modifyPackets( $packets )
    {
        foreach ( $packets as $packet )
        {
            $prot = $this->getProtocol( $packet['prot'] );
            $packet = $prot->modifyPacket( $packet );
        }
        return $packets;
    }

    private function getProtocol( $name )
    {
        if ( ( $name, $this->prot ) )
        {
            return $this->prot[$name];
        }
        $file = "query/".$name.".php";
        $class = "Query_Protocol_".$name;
        require_once( $file );
        if ( !( $class ) )
        {
            ( "Query::setFilter: unable to load protocol [".$name."].", E_USER_ERROR );
        }
        $this->prot[$name] = new $class( );
        return $this->prot[$name];
    }

    private function getPackets( $servers )
    {
        $result = array( );
        foreach ( $servers as $id => $server )
        {
            $packets = $this->cfg->getPackets( $server['pack'] );
            $chall = false;
            if ( isset( $packets['challenge'] ) )
            {
                $chall = $packets['challenge'];
                unset( $packets['challenge'] );
            }
            foreach ( $packets as $packetname => $packet )
            {
                $p = array( );
                $p['sid'] = $id;
                $p['name'] = $packetname;
                $p['data'] = $packet;
                $p['addr'] = $server['addr'];
                $p['port'] = $server['port'];
                $p['prot'] = $server['prot'];
                $p['transport'] = $server['transport'];
                if ( $chall !== false )
                {
                    $p['challenge'] = $chall;
                    ( $result, $p );
                }
                else
                {
                    ( $result, $p );
                }
            }
        }
        return $result;
    }

    private function merge( $arr1, $arr2 )
    {
        if ( !( $arr2 ) )
        {
            return $arr1;
        }
        foreach ( $arr2 as $key => $val2 )
        {
            if ( !isset( $arr1[$key] ) )
            {
                $arr1[$key] = $val2;
                continue;
            }
            $val1 = $arr1[$key];
            if ( ( $val1 ) )
            {
                $arr1[$key] = $this->merge( $val1, $val2 );
            }
        }
        return $arr1;
    }

    private function processChallengeResponse( $prot, $data, $response )
    {
        $result = "";
        $prot = $this->getProtocol( $prot );
        $prot->setData( new Query_Buffer( $response ) );
        try
        {
            $result = $prot->parseChallenge( $data );
        }
        catch ( Query_ParsingException $e )
        {
            if ( $this->getOption( "debug" ) )
            {
                print $e;
            }
        }
        return $result;
    }

    private function processChallengeResponses( $packets )
    {
        foreach ( $packets as $pid => $packet )
        {
            if ( !isset( $packet['challenge'] ) )
            {
                continue;
            }
            if ( !isset( $packet['response'][0] ) )
            {
                unset( $packet );
                continue;
            }
            $prot = $packet['prot'];
            $data = $packet['data'];
            $resp = $packet['response'][0];
            $packet['data'] = $this->processChallengeResponse( $prot, $data, $resp );
            if ( empty( $packet['data'] ) )
            {
                unset( $packet );
                continue;
            }
            unset( $packet['response'] );
        }
        return $packets;
    }

    private function processResponse( $protname, $packetname, $data )
    {
        $debug = $this->getOption( "debug" );
        if ( !isset( $data ) || ( $data ) === 0 )
        {
            return array( );
        }
        $prot = $this->getProtocol( $protname );
        $call = array(
            $prot,
            $packetname
        );
        try
        {
            $data = $prot->preprocess( $data );
            if ( $data == false )
            {
                return array( );
            }
        }
        catch ( Query_ParsingException $e )
        {
            if ( $debug )
            {
                print $e;
            }
        }
        if ( !( $call ) )
        {
            ( "Query::processResponse: unable to call ".$protname."::".$packetname.".", E_USER_ERROR );
        }
        $prot->setData( new Query_Buffer( $data ), new Query_Result( ) );
        try
        {
            ( $call );
        }
        catch ( Query_ParsingException $e )
        {
            if ( $debug )
            {
                print $e;
            }
        }
        return $prot->getData( );
    }

    private function processRaw( $packets, $servers )
    {
        $results = array( );
        foreach ( $servers as $sid => $server )
        {
            $results[$sid] = array( );
        }
        foreach ( $packets as $packet )
        {
            if ( !isset( $packet['response'] ) )
            {
                $packet['response'] = null;
            }
            $results[$packet['sid']][$packet['name']] = $packet['response'];
        }
        return $results;
    }

    private function processResponses( $packets, $servers )
    {
        $results = array( );
        foreach ( $servers as $sid => $server )
        {
            $results[$sid] = array( );
        }
        foreach ( $packets as $packet )
        {
            if ( !isset( $packet['response'] ) )
            {
                continue;
            }
            $name = $packet['name'];
            $prot = $packet['prot'];
            $sid = $packet['sid'];
            $result = $this->processResponse( $prot, $name, $packet['response'] );
            $results[$sid] = $this->merge( $results[$sid], $result );
        }
        foreach ( $results as $sid => $result )
        {
            $sv = $servers[$sid];
            $result['gq_online'] = !empty( $result );
            $result['gq_address'] = $sv['addr'];
            $result['gq_port'] = $sv['port'];
            $result['gq_prot'] = $sv['prot'];
            $result['gq_type'] = $sv['type'];
        }
        return $results;
    }

}

class Query_Buffer
{

    private $data = NULL;
    private $length = NULL;
    private $index = 0;

    public function __construct( $data )
    {
        $this->data = $data;
        $this->length = ( $data );
    }

    public function getData( )
    {
        return $this->data;
    }

    public function getBuffer( )
    {
        return ( $this->data, $this->index );
    }

    public function getLength( )
    {
        return ( $this->length - $this->index, 0 );
    }

    public function read( $length = 1 )
    {
        if ( $this->length < $length + $this->index )
        {
            throw new Query_ParsingException( $this );
        }
        $string = ( $this->data, $this->index, $length );
        $this->index += $length;
        return $string;
    }

    public function readLast( )
    {
        $len = ( $this->data );
        $string = $this->data[( $this->data ) - 1];
        $this->data = ( $this->data, 0, $len - 1 );
        $this->length -= 1;
        return $string;
    }

    public function lookAhead( $length = 1 )
    {
        $string = ( $this->data, $this->index, $length );
        return $string;
    }

    public function skip( $length = 1 )
    {
        $this->index += $length;
    }

    public function goto( $index )
    {
        $this->index = ( $index, $this->length - 1 );
    }

    public function getPosition( )
    {
        return $this->index;
    }

    public function readString( $delim = "\x00" )
    {
        $len = ( $this->data, $delim, ( $this->index, $this->length ) );
        if ( $len === false )
        {
            return $this->read( ( $this->data ) - $this->index );
        }
        $string = $this->read( $len - $this->index );
        ++$this->index;
        return $string;
    }

    public function readPascalString( $offset = 0, $read_offset = false )
    {
        $len = $this->readInt8( );
        $offset = ( $len - $offset, 0 );
        if ( $read_offset )
        {
            return $this->read( $offset );
        }
        return ( $this->read( $len ), 0, $offset );
    }

    public function readStringMulti( $delims, $delimfound = null )
    {
        $pos = array( );
        foreach ( $delims as $delim )
        {
            if ( $p = ( $this->data, $delim, ( $this->index, $this->length ) ) )
            {
                $pos[] = $p;
            }
        }
        if ( empty( $pos ) )
        {
            return $this->read( ( $this->data ) - $this->index );
        }
        ( $pos );
        $string = $this->read( $pos[0] - $this->index );
        $delimfound = $this->read( );
        return $string;
    }

    public function readInt32( )
    {
        $int = ( "Lint", $this->read( 4 ) );
        return $int['int'];
    }

    public function readInt16( )
    {
        $int = ( "Sint", $this->read( 2 ) );
        return $int['int'];
    }

    public function readInt8( )
    {
        return ( $this->read( 1 ) );
    }

    public function readFloat32( )
    {
        $float = ( "ffloat", $this->read( 4 ) );
        return $float['float'];
    }

    public function toFloat( $string )
    {
        if ( ( $string ) !== 4 )
        {
            return false;
        }
        $float = ( "ffloat", $string );
        return $float['float'];
    }

    public function toInt( $string, $bits = 8 )
    {
        if ( ( $string ) !== $bits / 8 )
        {
            return false;
        }
        switch ( $bits )
        {
        case 8 :
            $int = ( $string );
            break;
        case 16 :
            $int = ( "Sint", $string );
            $int = $int['int'];
            break;
        case 32 :
        }
        $int = ( "Lint", $string );
        $int = $int['int'];
        break;
        $int = false;
        break;
        return $int;
    }

}

class Query_Config
{

    private $games = NULL;
    private $packets = NULL;

    public function __construct( )
    {
        $this->readPacketConfig( );
    }

    private function readIniFile( $path )
    {
        $path = "query/".$path.".ini";
        $data = @( $path, true );
        if ( ( $data ) == 0 )
        {
            $msg = ( "Query_Config::readIniFile: unable to read file [%s].", $path );
            ( $msg, E_USER_ERROR );
        }
        return $data;
    }

    private function readGamesConfig( )
    {
        include( "games.php" );
        $this->games = $games;
        foreach ( $this->games as $id => $game )
        {
            if ( !isset( $game['prot'] ) )
            {
                $game['prot'] = $id;
            }
            if ( !isset( $game['pack'] ) )
            {
                $game['pack'] = $game['prot'];
            }
            if ( !isset( $game['transport'] ) )
            {
                $game['transport'] = "udp";
            }
        }
        ( $this->games );
    }

    private function readPacketConfig( )
    {
        include( "games.php" );
        $this->packets = $games;
        foreach ( $this->packets as $prot => $packets )
        {
            foreach ( $packets as $id => $packet )
            {
                $this->packets[$prot][$id] = ( $packet );
            }
        }
    }

    public function getGame( $gid, $addr, $port )
    {
        $game['name'] = "Swift Panel";
        $game['prot'] = $gid;
        $game['pack'] = $game['prot'];
        $game['transport'] = "udp";
        $game['type'] = $gid;
        $game['addr'] = $addr;
        $game['port'] = $port;
        return $game;
    }

    public function getPackets( $pid )
    {
        if ( !( $pid, $this->packets ) )
        {
            $msg = ( "Unknown packet %s.", $pid );
            ( $msg, E_USER_ERROR );
        }
        return $this->packets[$pid];
    }

}

class Query_Communicate
{

    private $sockets = array( );

    public function query( $packets, $timeout, $type = "data", $sock )
    {
        foreach ( $packets as $pid => $packet )
        {
            if ( !isset( $packet[$type] ) )
            {
                continue;
            }
            $socket = $this->open( $packet['addr'], $packet['port'], $pid, $sock, $timeout, $packet['transport'] );
            if ( $socket === false )
            {
                continue;
            }
            $this->write( $socket, $packet[$type] );
            $sock = $sock == 0 ? 0 : ++$sock;
        }
        $responses = $this->listen( $timeout );
        foreach ( $this->sockets as $pid => $socket )
        {
            $sid = ( integer )$socket;
            if ( isset( $responses[$sid] ) )
            {
                $packets[$pid]['response'] = $responses[$sid];
            }
        }
        if ( $type != "challenge" )
        {
            $this->close( );
        }
        return $packets;
    }

    private function open( $address, $port, $pid, $sock, $timeout, $transport = "udp" )
    {
        if ( isset( $this->sockets[$pid] ) )
        {
            return $this->sockets[$pid];
        }
        $address = $this->getIp( $address );
        if ( $address === false )
        {
            return false;
        }
        $errno = null;
        $errstr = null;
        $opts['socket']['bindto'] = "0:".$sock;
        $context = ( $opts );
        $addr = ( "%s://%s:%d", $transport, $address, $port );
        $socket = @( $addr, $errno, $errstr, $timeout / 1000, STREAM_CLIENT_CONNECT, $context );
        if ( $socket !== false )
        {
            $this->sockets[$pid] = $socket;
            ( $socket, false );
        }
        return $socket;
    }

    private function write( $socket, $packet )
    {
        ( $socket, $packet );
    }

    private function listen( $timeout )
    {
        $loops = 0;
        $maxloops = 50;
        $result = array( );
        $starttime = ( true );
        $r = $this->sockets;
        $w = null;
        $e = null;
        if ( ( $this->sockets ) == 0 )
        {
            return $result;
        }
        while ( 0 < ( $t = $timeout * 1000 - ( ( true ) - $starttime ) * 10000 ) )
        {
            $s = ( $r, $w, $e, 0, $t );
            if ( $s === false || $s <= 0 )
            {
                break;
            }
            if ( $maxloops < ++$loops )
            {
                break;
            }
            foreach ( $r as $socket )
            {
                $response = ( $socket, 2048 );
                if ( $response === false )
                {
                    continue;
                }
                $result[( integer )$socket][] = $response;
            }
            $r = $this->sockets;
        }
        return $result;
    }

    private function close( )
    {
        foreach ( $this->sockets as $socket )
        {
            ( $socket );
        }
        $this->sockets = array( );
    }

    public function getIp( $address )
    {
        $preg = "#^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\\.){3}"."(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\$#";
        if ( !( $preg, $address ) )
        {
            $result = ( $address );
            if ( $result === $address )
            {
                $result = false;
            }
        }
        else
        {
            $result = $address;
        }
        return $result;
    }

}

class Query_ParsingException
{

    private $packet = NULL;
    protected $format = "Could not parse packet for server \"%s\"";

    public function __construct( $packet = null )
    {
        $this->packet = $packet;
        $FN_-2147483642( "" );
    }

    public function getPacket( )
    {
        return $packet;
    }

}

class Query_Result
{

    private $result = array( );

    public function add( $name, $value )
    {
        $this->result[$name] = $value;
    }

    public function addPlayer( $name, $value )
    {
        $this->addSub( "players", $name, $value );
    }

    public function addTeam( $name, $value )
    {
        $this->addSub( "teams", $name, $value );
    }

    public function addSub( $sub, $key, $value )
    {
        if ( !isset( $this->result[$sub] ) || !( $this->result[$sub] ) )
        {
            $this->result[$sub] = array( );
        }
        $found = false;
        $i = 0;
        while ( $i != ( $this->result[$sub] ) )
        {
            if ( !isset( $this->result[$sub][$i][$key] ) )
            {
                $this->result[$sub][$i][$key] = $value;
                $found = true;
                break;
            }
            ++$i;
        }
        if ( !$found )
        {
            $this->result[$sub][][$key] = $value;
        }
    }

    public function fetch( )
    {
        return $this->result;
    }

    public function get( $var )
    {
        return isset( $this->result[$var] ) ? $this->result[$var] : null;
    }

}

class Query_Filter
{

    protected $params = array( );

    public function __construct( $params )
    {
        if ( ( $params ) )
        {
            foreach ( $params as $key => $param )
            {
                $this->params[$key] = $param;
            }
        }
        else
        {
            $this->params = $params;
        }
    }

    public function filter( $results, $servers )
    {
        return $results;
    }

}

class Query_Filter_normalise extends Query_Filter
{

    private $translate = NULL;
    private $allowed = NULL;

    public function __construct( )
    {
        $this->vars = array(
            "dedicated" => array( "listenserver", "dedic", "bf2dedicated", "netserverdedicated", "bf2142dedicated" ),
            "gametype" => array( "ggametype", "sigametype", "matchtype" ),
            "hostname" => array( "svhostname", "servername", "siname" ),
            "mapname" => array( "map", "simap" ),
            "maxplayers" => array( "svmaxclients", "simaxplayers", "maxclients" ),
            "mod" => array( "game", "gamedir", "gamevariant" ),
            "numplayers" => array( "clients", "sinumplayers" ),
            "password" => array( "protected", "siusepass", "sineedpass", "pswrd", "gneedpass" ),
            "players" => array( "player" )
        );
        $this->player = array(
            "name" => array( "nick", "player" ),
            "score" => array( "score", "kills", "frags", "skill" ),
            "ping" => array( )
        );
    }

    public function filter( $original, $server )
    {
        $result = array( );
        if ( empty( $original ) )
        {
            return $result;
        }
        $result = $this->normalise( $original, $this->vars );
        if ( ( $result['gq_players'] ) )
        {
            $result['players'] = $result['gq_players'];
            foreach ( $result['players'] as $key => $player )
            {
                $result['players'][$key] = ( $player, $this->normalise( $player, $this->player ) );
            }
        }
        else
        {
            $result['players'] = array( );
        }
        unset( $result['gq_players'] );
        $result['gq_numplayers'] = ( $result['players'] );
        $result = ( $original, $result );
        ( $result );
        return $result;
    }

    private function normalise( $data, $vars )
    {
        $new = $this->fill( $vars );
        foreach ( $data as $var => $value )
        {
            $stripped = ( ( "_", "", $var ) );
            foreach ( $vars as $target => $sources )
            {
                if ( !( $target == $stripped || ( $stripped, $sources ) ) )
                {
                    continue;
                }
                $new["gq_".$target] = $value;
                unset( $vars[$target] );
                break;
                break;
            }
        }
        return $new;
    }

    private function fill( $vars, $val = false )
    {
        $data = array( );
        foreach ( $vars as $target => $source )
        {
            $data["gq_".$target] = $val;
        }
        return $data;
    }

}

abstract class Query_Protocol
{

    protected $p = NULL;
    protected $r = NULL;

    public function setData( $packet, $result = null )
    {
        $this->p = $packet;
        $this->r = $result;
    }

    public function getData( )
    {
        return $this->r->fetch( );
    }

    public function preprocess( $packets )
    {
        return ( "", $packets );
    }

    public function parseChallenge( $packet )
    {
        return $packet;
    }

    public function modifyPacket( $packet_conf )
    {
        return $packet_conf;
    }

}

?>
