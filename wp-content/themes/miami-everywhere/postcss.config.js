/**
 * Exports the PostCSS configuration.
 *
 * @returns {string} PostCSS options.
 */
module.exports = ({ file, options, env }) => ({ /* eslint-disable-line */
	plugins: {
		'postcss-import': {},
		'postcss-preset-env': {
			stage: 0,
			autoprefixer: {
				grid: true,
			},
			features: {
				'color-function': { preserve: true },
				'nesting-rules': true,
			},
		},
		'postcss-editor-styles':
			file.basename === 'editor-style.css' || file.basename === 'editor-style.scss'
				? {
						scopeTo: '.editor-styles-wrapper',
						ignore: [
							':root',
							'.edit-post-visual-editor.editor-styles-wrapper',
							'.wp-toolbar',
						],
						remove: ['html', ':disabled', '[readonly]', '[disabled]'],
						tags: ['button', 'input', 'label', 'select', 'textarea', 'form'],
					}
				: false,
		cssnano:
			env === 'production'
				? {
						preset: [
							'default',
							{
								autoprefixer: false,
								calc: {
									precision: 8,
									preserve: true,
								},
								convertValues: true,
								discardComments: {
									removeAll: true,
								},
								mergeLonghand: false,
								zindex: false,
							},
						],
					}
				: false,
	},
});
