module.exports = {
  customSyntax: 'postcss-scss',
  plugins: [
    // REMOVE: 'stylelint-scss' // Cannot use with stylelint v15 + 10up config
  ],
  extends: [
    '@10up/stylelint-config',
  ],
  rules: {
    // Disable the invalid media query rule since we're using SCSS variables.
    "media-query-no-invalid": null,
    // Disable the default at-rule rule since it doesn't recognize SCSS at‑rules.
    "at-rule-no-unknown": null,
    // REMOVE: "scss/at-rule-no-unknown": true, // Cannot use this rule
    'selector-class-pattern': null,
    'no-descending-specificity': null,
    'selector-nested-pattern': null,
    'declaration-block-no-redundant-longhand-properties': [
      true,
      {
        ignoreShorthands: ['grid-template'],
      },
    ],
    "unit-no-unknown": true,
    "selector-max-id": 0,
    "shorthand-property-no-redundant-values": true,
    "stylistic/string-quotes": null,
    "stylistic/declaration-colon-newline-after": null,
    "rule-empty-line-before": null,
    "at-rule-empty-line-before": null,
    "stylistic/block-closing-brace-newline-after": null,
    "stylistic/function-parentheses-space-inside": null,
    "stylistic/function-comma-space-after": null,
    "stylistic/value-list-comma-newline-after": null,
    "stylistic/selector-combinator-space-after": null,
    "stylistic/selector-combinator-space-before": null,
    // Disable the strict value rule causing errors with system colors
    "scale-unlimited/declaration-strict-value": null, // Set back to null
    "annotation-no-unknown": null, // Allow SCSS !default flag
  },
};
