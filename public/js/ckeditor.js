import { ClassicEditor as ClassicEditorBase } from "@ckeditor/ckeditor5-editor-classic";
import { Essentials } from "@ckeditor/ckeditor5-essentials";
import { Autoformat } from "@ckeditor/ckeditor5-autoformat";
import { Bold, Italic } from "@ckeditor/ckeditor5-basic-styles";
import { BlockQuote } from "@ckeditor/ckeditor5-block-quote";
import { Heading } from "@ckeditor/ckeditor5-heading";
import { Link } from "@ckeditor/ckeditor5-link";
import { List } from "@ckeditor/ckeditor5-list";
import { Paragraph } from "@ckeditor/ckeditor5-paragraph";
import { Image } from "@ckeditor/ckeditor5-image";
import { CKFinderUploadAdapter } from "@ckeditor/ckeditor5-adapter-ckfinder";
import { CKFinder } from "@ckeditor/ckeditor5-ckfinder";

export default class ClassicEditor extends ClassicEditorBase {}

ClassicEditor.builtinPlugins = [
    Essentials,
    Autoformat,
    Bold,
    Italic,
    BlockQuote,
    Heading,
    Link,
    List,
    Paragraph,
    Image,
    CKFinderUploadAdapter,
    CKFinder,
];

ClassicEditor.defaultConfig = {
    toolbar: {
        items: [
            "heading",
            "|",
            "bold",
            "italic",
            "link",
            "bulletedList",
            "numberedList",
            "blockQuote",
            "undo",
            "redo",
            "ckfinder",
        ],
    },
    language: "en",
};

ClassicEditor
    // Note that you do not have to specify the plugin and toolbar configuration — using defaults from the build.
    .create(document.querySelector("#editor"), {
        ckfinder: {
            // Upload the images to the server using the CKFinder QuickUpload command.
            uploadUrl: "/ckfinder/connector",
        },
    })
    .then((editor) => {
        console.log("Editor was initialized", editor);
    })
    .catch((error) => {
        console.error(error.stack);
    });
