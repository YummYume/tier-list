import { sveltekit } from '@sveltejs/kit/vite';
import { loadEnv } from 'vite';

/** @type {import('vite').UserConfig} */
const config = (mode) => {
	process.env = {...process.env, ...loadEnv(mode, process.cwd())};

	return {
		plugins: [sveltekit()],
		server: {
			watch: {
				usePolling: process.env.VITE_USE_POLLING === 'true'
			}
		}
	}
};

export default config;
