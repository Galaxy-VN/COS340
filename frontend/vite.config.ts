import { defineConfig } from 'vite'

export default defineConfig({
  server: {
    port: 3000,
    proxy: {
      '/phamgiahuy': {
        target: 'http://localhost:88/webbanhang',
        changeOrigin: true,
        rewrite: (path) => path.replace(/^\/phamgiahuy/, ''),
      }
    }
  }
})
