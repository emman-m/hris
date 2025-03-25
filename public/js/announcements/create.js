new TomSelect("#target", {
    create: false,
    sortField: {
        field: "text",
        direction: "asc"
    }
});

document.addEventListener("DOMContentLoaded", function () {
    let options = {
        selector: 'textarea[name="content"]',
        height: 300,
        menubar: false,
        statusbar: false,
        license_key: "gpl",
        plugins: [
            "advlist",
            "autolink",
            "lists",
            "link",
            "image",
            "charmap",
            "preview",
            "anchor",
            "searchreplace",
            "visualblocks",
            "code",
            "fullscreen",
            "insertdatetime",
            "media",
            "table",
            "code",
            "help",
            "wordcount",
        ],
        toolbar:
            "undo redo | formatselect fontsizeinput | " +
            "bold italic underline backcolor | alignleft aligncenter " +
            "alignright alignjustify | bullist numlist outdent indent | " +
            "link unlink image | " +
            "removeformat",
        content_style:
            "body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; -webkit-font-smoothing: antialiased; }",
    };
    if (localStorage.getItem("tablerTheme") === "dark") {
        options.skin = "oxide-dark";
        options.content_css = "dark";
    }
    tinyMCE.init(options);
});

