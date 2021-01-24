/**
 * Gutenberg Blocks
 *
 * All blocks are automatically included here
 * Webpack require.context() will search the 'blocks' dir for js files
 *
 */

const { registerBlockType } = wp.blocks;

 // Create a require context containing all matched block files.
 const context = require.context(
     '../blocks', // Look inside the blocks folder
     true, // Recursively search
     /index\.js$/ // Find 'index.js' files
 );

 context.keys().forEach( modulePath => {
     const block = context( modulePath );

     // Register each block using the wp registerBlockType function
     registerBlockType( block.name, block.settings );
 } );
