<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

class Config_File
{

    public $overwrite = TRUE;
    public $booleanize = TRUE;
    public $read_hidden = TRUE;
    public $fix_newlines = TRUE;
    public $_config_path = "";
    public $_config_data = array( );

    public function Config_File( $config_path = NULL )
    {
        if ( isset( $config_path ) )
        {
            $this->set_path( $config_path );
        }
    }

    public function set_path( $config_path )
    {
        if ( !empty( $config_path ) )
        {
            if ( !is_string( $config_path ) || !file_exists( $config_path ) || !is_dir( $config_path ) )
            {
                $this->_trigger_error_msg( "Bad config file path '{$config_path}'" );
                return;
            }
            if ( substr( $config_path, 0 - 1 ) != DIRECTORY_SEPARATOR )
            {
                $config_path .= DIRECTORY_SEPARATOR;
            }
            $this->_config_path = $config_path;
        }
    }

    public function get( $file_name, $section_name = NULL, $var_name = NULL )
    {
        if ( empty( $file_name ) )
        {
            $this->_trigger_error_msg( "Empty config file name" );
            return;
        }
        else
        {
            $file_name = $this->_config_path.$file_name;
            if ( !isset( $this->_config_data[$file_name] ) )
            {
                $this->load_file( $file_name, FALSE );
            }
        }
        if ( !empty( $var_name ) )
        {
            if ( empty( $section_name ) )
            {
                return $this->_config_data[$file_name]['vars'][$var_name];
            }
            else if ( isset( $this->_config_data[$file_name]['sections'][$section_name]['vars'][$var_name] ) )
            {
                return $this->_config_data[$file_name]['sections'][$section_name]['vars'][$var_name];
            }
            else
            {
                return array( );
            }
        }
        else if ( empty( $section_name ) )
        {
            return ( array )$this->_config_data[$file_name]['vars'];
        }
        else if ( isset( $this->_config_data[$file_name]['sections'][$section_name]['vars'] ) )
        {
            return ( array )$this->_config_data[$file_name]['sections'][$section_name]['vars'];
        }
        else
        {
            return array( );
        }
    }

    public function &get_key( $config_key )
    {
        list( $file_name, $section_name, $var_name ) = explode( "/", $config_key, 3 );
        $result =& $this->get( $file_name, $section_name, $var_name );
        return $result;
    }

    public function get_file_names( )
    {
        return array_keys( $this->_config_data );
    }

    public function get_section_names( $file_name )
    {
        $file_name = $this->_config_path.$file_name;
        if ( !isset( $this->_config_data[$file_name] ) )
        {
            $this->_trigger_error_msg( "Unknown config file '{$file_name}'" );
            return;
        }
        return array_keys( $this->_config_data[$file_name]['sections'] );
    }

    public function get_var_names( $file_name, $section = NULL )
    {
        if ( empty( $file_name ) )
        {
            $this->_trigger_error_msg( "Empty config file name" );
            return;
        }
        else if ( !isset( $this->_config_data[$file_name] ) )
        {
            $this->_trigger_error_msg( "Unknown config file '{$file_name}'" );
            return;
        }
        if ( empty( $section ) )
        {
            return array_keys( $this->_config_data[$file_name]['vars'] );
        }
        else
        {
            return array_keys( $this->_config_data[$file_name]['sections'][$section]['vars'] );
        }
    }

    public function clear( $file_name = NULL )
    {
        if ( $file_name === NULL )
        {
            $this->_config_data = array( );
        }
        else if ( isset( $this->_config_data[$file_name] ) )
        {
            $this->_config_data[$file_name] = array( );
        }
    }

    public function load_file( $file_name, $prepend_path = TRUE )
    {
        if ( $prepend_path && $this->_config_path != "" )
        {
            $config_file = $this->_config_path.$file_name;
        }
        else
        {
            $config_file = $file_name;
        }
        ini_set( "track_errors", TRUE );
        $fp = @fopen( $config_file, "r" );
        if ( !is_resource( $fp ) )
        {
            $this->_trigger_error_msg( "Could not open config file '{$config_file}'" );
            return FALSE;
        }
        $contents = ( $size = filesize( $config_file ) ) ? fread( $fp, $size ) : "";
        fclose( $fp );
        $this->_config_data[$config_file] = $this->parse_contents( $contents );
        return TRUE;
    }

    public function set_file_contents( $config_file, $contents )
    {
        $this->_config_data[$config_file] = $this->parse_contents( $contents );
        return TRUE;
    }

    public function parse_contents( $contents )
    {
        if ( $this->fix_newlines )
        {
            $contents = preg_replace( "!\\r\\n?!", "\n", $contents );
        }
        $config_data = array( );
        $config_data['sections'] = array( );
        $config_data['vars'] = array( );
        $vars =& $config_data['vars'];
        preg_match_all( "!^.*\\r?\\n?!m", $contents, $match );
        $lines = $match[0];
        $i = 0;
        $count = count( $lines );
        for ( ; $i < $count; $i++ )
        {
            $line = $lines[$i];
            if ( empty( $line ) )
            {
                continue;
            }
            if ( substr( $line, 0, 1 ) == "[" && preg_match( "!^\\[(.*?)\\]!", $line, $match ) )
            {
                if ( substr( $match[1], 0, 1 ) == "." )
                {
                    if ( $this->read_hidden )
                    {
                        $section_name = substr( $match[1], 1 );
                    }
                    else
                    {
                        unset( $vars );
                        $vars = array( );
                        continue;
                    }
                }
                else
                {
                    $section_name = $match[1];
                }
                if ( !isset( $config_data['sections'][$section_name] ) )
                {
                    $config_data['sections'][$section_name] = array(
                        "vars" => array( )
                    );
                }
                $vars =& $config_data['sections'][$section_name]['vars'];
                continue;
            }
            if ( preg_match( "/^\\s*(\\.?\\w+)\\s*=\\s*(.*)/s", $line, $match ) )
            {
                $var_name = rtrim( $match[1] );
                if ( strpos( $match[2], "\"\"\"" ) === 0 )
                {
                    $lines[$i] = substr( $match[2], 3 );
                    $var_value = "";
                    while ( $i < $count )
                    {
                        if ( ( $pos = strpos( $lines[$i], "\"\"\"" ) ) === FALSE )
                        {
                            $var_value .= $lines[$i++];
                        }
                        else
                        {
                            $var_value .= substr( $lines[$i], 0, $pos );
                            break;
                        }
                    }
                    $booleanize = FALSE;
                }
                else
                {
                    $var_value = preg_replace( "/^(['\"])(.*)\\1\$/", "\\2", rtrim( $match[2] ) );
                    $booleanize = $this->booleanize;
                }
                $this->_set_config_var( $vars, $var_name, $var_value, $booleanize );
            }
        }
        return $config_data;
    }

    public function _set_config_var( &$container, $var_name, $var_value, $booleanize )
    {
        if ( substr( $var_name, 0, 1 ) == "." )
        {
            if ( !$this->read_hidden )
            {
                return;
            }
            else
            {
                $var_name = substr( $var_name, 1 );
            }
        }
        if ( !preg_match( "/^[a-zA-Z_]\\w*\$/", $var_name ) )
        {
            $this->_trigger_error_msg( "Bad variable name '{$var_name}'" );
            return;
        }
        if ( $booleanize )
        {
            if ( preg_match( "/^(on|true|yes)\$/i", $var_value ) )
            {
                $var_value = TRUE;
            }
            else if ( preg_match( "/^(off|false|no)\$/i", $var_value ) )
            {
                $var_value = FALSE;
            }
        }
        if ( !isset( $container[$var_name] ) || $this->overwrite )
        {
            $container[$var_name] = $var_value;
        }
        else
        {
            settype( $container[$var_name], "array" );
            $container[$var_name][] = $var_value;
        }
    }

    public function _trigger_error_msg( $error_msg, $error_type = E_USER_WARNING )
    {
        trigger_error( "Config_File error: {$error_msg}", $error_type );
    }

}

?>
