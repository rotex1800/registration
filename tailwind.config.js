/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ], theme: {
        extend: {
            gridTemplateColumns: {
                'input': 'max-content auto'
            }
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
