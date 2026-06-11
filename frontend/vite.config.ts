import { defineConfig } from 'vite'

export default defineConfig({
  server: {
    port: 3000,
    proxy: {
      '/api': {
        target: 'http://localhost:88/webbanhang',
        changeOrigin: true,
      }
    }
  }
})
