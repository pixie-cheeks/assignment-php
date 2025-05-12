import pixie from '@pixie-cheeks/eslint-config';
import { defineConfig, globalIgnores } from 'eslint/config';

export default defineConfig([
  ...pixie.base,
  {
    languageOptions: {
      globals: pixie.globals.browser,
    },
    rules: {
      'no-console': ['warn', { allow: ['warn', 'error'] }],
    },
  },
  {
    files: ['{lint-staged,eslint}.config.js'],
    rules: {
      'import-x/no-default-export': 'off',
    },
  },
  globalIgnores(['src/global']),
  pixie.prettier,
]);
