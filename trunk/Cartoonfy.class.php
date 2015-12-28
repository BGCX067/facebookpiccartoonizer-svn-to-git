<?php
/*
 *
 *	Cartoonfy effect generator class.
 *
 */
Class Cartoonfy {
    var $triplevel;
    var $diffspace;
    var $i0;
    var $i1;
	/*
	 *
	 *	Constructor
	 *
	 */
    function Cartoonfy ( $p_image, $p_triplevel, $p_diffspace ) {

        $this->triplevel = (int)( 2000.0 + 5000.0 * $p_triplevel );
        $this->diffspace = (int)( $p_diffspace * 32.0 );
        $this->i0 = imageCreateFromString ( file_get_contents($p_image) );
        if ( $this->i0 ) {
            $this->i1 = imageCreateTrueColor ( imageSx ( $this->i0 ), imageSy ( $this->i0 ) );
            for ( $x = (int)$this->diffspace; $x < imageSx ( $this->i0 ) - ( 1 + (int)$this->diffspace ); $x++ ) {
                for ( $y = (int)$this->diffspace; $y < imageSy ( $this->i0 ) - ( 1 + (int)$this->diffspace ); $y++ ) {
                    $t = Cartoonfy::GetMaxContrast ( $x, $y );
                    if ( $t > $this->triplevel ) {
                        imageSetPixel ( $this->i1, $x, $y, 0 );
                    }
                    else {
                        imageSetPixel ( $this->i1, $x, $y, Cartoonfy::FlattenColor ( imageColorAt ( $this->i0, $x, $y ) ) );
                    }                    
                }
                //usleep(1000);
            }
            imageDestroy ( $this->i0 );
        }
        else {
            print "<b>".$p_image."</b> is not supported image format!";
            exit;
        }
    }
	/*
	 *
	 *	Non-public functions
	 *
	 */
    function R ( $i ) {return ( ( $i >> 16 ) & 0x000000FF );}
    function G ( $i ) {return ( ( $i >> 8 ) & 0x000000FF );}
    function B ( $i ) {return ( $i & 0x000000FF );}
    function RGB ( $r, $g, $b ) {return  ( $r << 16 ) + ( $g << 8 ) + ( $b );}
    function gmerror ( $cc1, $cc2 ) {return ( ( ( ( Cartoonfy::R ( $cc1 ) - Cartoonfy::R ( $cc2 ) ) * ( Cartoonfy::R ( $cc1 ) - Cartoonfy::R ( $cc2 ) ) ) + ( ( Cartoonfy::G ( $cc1 ) - Cartoonfy::G ( $cc2 ) ) * ( Cartoonfy::G ( $cc1 ) - Cartoonfy::G ( $cc2 ) ) ) + ( ( Cartoonfy::B ( $cc1 ) - Cartoonfy::B ( $cc2 ) ) * ( Cartoonfy::B ( $cc1 ) - Cartoonfy::B ( $cc2 ) ) ) ) );}
    function FlattenColor ( $c ) {return Cartoonfy::RGB ( ( ( Cartoonfy::R ( $c ) ) >> 5 ) << 5, ( ( Cartoonfy::G ( $c ) ) >> 5 ) << 5, ( ( Cartoonfy::B ( $c ) ) >> 5 ) << 5 );}
    function GetMaxContrast ( $x, $y ) {
        $c1;
        $c2;
        $error	= 0;
        $max	= 0;

        $c1 = imageColorAt ( $this->i0, $x - (int)$this->diffspace, $y );
        $c2 = imageColorAt ( $this->i0, $x + (int)$this->diffspace, $y );
        $error = Cartoonfy::gmerror ( $c1, $c2 );
        if ( $error > $max ) $max = $error;

        $c1 = imageColorAt ( $this->i0, $x, $y - (int)$this->diffspace );
        $c2 = imageColorAt ( $this->i0, $x, $y + (int)$this->diffspace );
        $error = Cartoonfy::gmerror ( $c1, $c2 );
        if ( $error > $max ) $max = $error;

        $c1 = imageColorAt ( $this->i0, $x - (int)$this->diffspace, $y - (int)$this->diffspace );
        $c2 = imageColorAt ( $this->i0, $x + (int)$this->diffspace, $y + (int)$this->diffspace );
        $error = Cartoonfy::gmerror ( $c1, $c2 );
        if ( $error > $max ) $max = $error;

        $c1 = imageColorAt ( $this->i0, $x + (int)$this->diffspace, $y - (int)$this->diffspace );
        $c2 = imageColorAt ( $this->i0, $x - (int)$this->diffspace, $y + (int)$this->diffspace );
        $error = Cartoonfy::gmerror ( $c1, $c2 );
        if ( $error > $max ) $max = $error;

        return ( $max );
    }
	/*
	 *
	 *	Public functions
	 *
	 */
    function showCartoonfy ( $p_ext, $p_dis ) {
        switch ( strtolower ( $p_ext ) ) {
            case "jpg":
                header ( 'Content-type:image/'.strtolower ( $p_ext ) );
                if ( $p_dis ) {
                    header ( 'Content-disposition:attachment;filename='.time( ).'.'.strtolower ( $p_ext ) );
                }
                imageJpeg ( $this->i1 );
                break;
            case "jpeg":
                header ( 'Content-type:image/'.strtolower ( $p_ext ) );
                if ( $p_dis ) {
                    header ( 'Content-disposition:attachment;filename='.time( ).'.'.strtolower ( $p_ext ) );
                }
                imageJpeg ( $this->i1 );
                break;
            case "gif":
                header ( 'Content-type:image/'.strtolower ( $p_ext ) );
                if ( $p_dis ) {
                    header ( 'Content-disposition:attachment;filename='.time( ).'.'.strtolower ( $p_ext ) );
                }
                imageGif ( $this->i1 );
                break;
            case "png":
                header ( 'Content-type:image/'.strtolower ( $p_ext ) );
                if ( $p_dis ) {
                    header ( 'Content-disposition:attachment;filename='.time( ).'.'.strtolower ( $p_ext ) );
                }
                imagePng ( $this->i1 );
                break;
            default:
                print "<b>".$p_ext."</b> is not supported image format!";
                exit;
        }
        imageDestroy ( $this->i1 );
    }
}
?>
