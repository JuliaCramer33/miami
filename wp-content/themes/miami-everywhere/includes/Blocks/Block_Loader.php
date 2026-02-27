<?php
/**
 * Block Loader Class
 *
 * @package MiamiEverywhere
 */

namespace MiamiEverywhere\Blocks;

/**
 * Block Loader Class
 */
class Block_Loader {
    /**
     * Initialize the block loader
     *
     * @return void
     */
    public static function init() {
        add_action( 'acf/init', array( __CLASS__, 'register_blocks' ) );
    }

    /**
     * Register ACF blocks by explicitly including their registration files.
     *
     * @return void
     */
    public static function register_blocks() {
        // Ensure ACF function exists before proceeding
        if ( ! function_exists( 'acf_register_block_type' ) ) {
            // Optional: Log an error if ACF isn't active/loaded
            // error_log('ACF Pro function acf_register_block_type not found. Cannot register blocks.');
            return;
        }

        $blocks_dir = __DIR__; // Current directory: includes/blocks/

        // Explicitly list known block subdirectories
        $blocks_to_register = [
            'image-card-grid',
            'image-overlap-card',
            'related-stories',
            'stats',
            'featured-testimonial'
        ];

        // Loop through the explicit list and include the register.php file
        foreach ($blocks_to_register as $block_name) {
            $register_file = $blocks_dir . '/' . $block_name . '/register.php';

            // error_log("Block Loader attempting to load: " . $register_file); // DEBUGGING REMOVED

            if ( file_exists( $register_file ) ) {
                require_once $register_file;
            } else {
                // Optional: Log if a listed block's register file is missing
                // error_log( 'Block registration file not found for explicit block: ' . $block_name . ' at ' . $register_file );
            }
        }
    }
}
