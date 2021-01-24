
/**
 * BLOCK: sample-block
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 *
 */

 // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
 export const name = 'os-blocks/sample-block';

 export const settings = {
     title: 'OS Blocks - Sample',
     icon: 'shield',
     category: 'common',
     keywords: [ 'os', 'sample' ],
	edit: blockEdit,
	save: blockSave,
 };

 const blockEdit = ( props ) => {
    // Creates a <p class='wp-block-ob-blocks-sample-block'></p>.
    return (
        <div className={ props.className }>
            <p>— Hello from the backend.</p>
            <p>
                OS Blocks: <code>sample-block</code> is a new Gutenberg block
            </p>
            <p>
                It was created via{ ' ' }
                <code>
                    <a href="https://github.com/ahmadawais/create-guten-block">
                        create-guten-block
                    </a>
                </code>.
            </p>
        </div>
    );
 }

 const blockSave = ( props ) => {
    return (
        <div className={ props.className }>
            <p>— Hello from the frontend.</p>
            <p>
                OS Blocks: <code>sample-block</code> is a new Gutenberg block
            </p>
            <p>
                It was created via{ ' ' }
                <code>
                    <a href="https://github.com/ahmadawais/create-guten-block">
                        create-guten-block
                    </a>
                </code>.
            </p>
        </div>
    );
 }
