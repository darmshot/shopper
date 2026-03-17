import hugerte, {EditorOptions} from 'hugerte';

export default  function (el:HTMLTextAreaElement) {
    let options: Partial<EditorOptions> = {
        selector: `#${el.id}`,
        base_url: '/build/vendor/hugerte',
        height: 300,
        menubar: false,
        statusbar: false,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap',
            'preview', 'anchor', 'searchreplace', 'visualblocks', 'code',
            'fullscreen', 'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | formatselect | bold italic backcolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | removeformat',
    };

    if (localStorage.getItem("tablerTheme") === 'dark') {
        options.skin = 'oxide-dark';
        options.content_css = ['dark'];
    }

    hugerte.init(options);
}
