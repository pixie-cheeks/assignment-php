/**
 * @filename: lint-staged.config.js
 * @type {import('lint-staged').Configuration}
 */
export default {
  '*': ['prettier --write --ignore-unknown', 'cspell'],
  '*.php': (stagedFiles) => {
    const spaceSeparated = stagedFiles.join(' ');
    const commaSeparated = stagedFiles.join(',');
    return [
      `php -l ${spaceSeparated}`,
      `composer exec psalm -- ${spaceSeparated}`,
      `composer exec phpmd ${commaSeparated} ansi rulesets.xml`,
    ];
  },
  '*.js': ['eslint --no-warn-ignored --max-warnings 0'],
  '*.css': ['stylelint'],
};
