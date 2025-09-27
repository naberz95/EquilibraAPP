<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl p-8 space-y-6">
      <!-- Logo Section -->
      <div class="text-center">
        <div class="mx-auto w-20 h-20 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full flex items-center justify-center mb-4">
          <img 
            v-if="logoLoaded"
            src="/logo.png" 
            alt="EquilibraAPP Logo" 
            class="w-12 h-12 object-contain"
            @error="showDefaultLogo"
          >
          <svg v-else class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
          </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">EquilibraAPP</h1>
        <p class="text-gray-600 text-sm">Sistema de Gestión Médica</p>
      </div>

      <!-- Login Form -->
      <form @submit.prevent="handleLogin" class="space-y-6">
        <!-- Email Field -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
            Correo Electrónico
          </label>
          <div class="relative">
            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              :class="[
                'w-full px-4 py-3 pl-11 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200',
                errors.email ? 'border-red-500 bg-red-50' : 'border-gray-300'
              ]"
              placeholder="usuario@example.com"
            />
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
              </svg>
            </div>
          </div>
          <p v-if="errors.email" class="text-red-600 text-sm mt-1">{{ errors.email }}</p>
        </div>

        <!-- Password Field -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
            Contraseña
          </label>
          <div class="relative">
            <input
              id="password"
              v-model="form.password"
              :type="showPassword ? 'text' : 'password'"
              required
              :class="[
                'w-full px-4 py-3 pl-11 pr-11 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200',
                errors.password ? 'border-red-500 bg-red-50' : 'border-gray-300'
              ]"
              placeholder="••••••••"
            />
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
            </div>
            <button
              type="button"
              @click="showPassword = !showPassword"
              class="absolute inset-y-0 right-0 pr-3 flex items-center"
            >
              <svg v-if="showPassword" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464M9.878 9.878a3 3 0 00-.007 4.243m4.249-4.243l1.414-1.414M14.121 14.121A3 3 0 009.878 9.878m4.243 4.243L19.5 19.5"/>
              </svg>
              <svg v-else class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
            </button>
          </div>
          <p v-if="errors.password" class="text-red-600 text-sm mt-1">{{ errors.password }}</p>
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input
              id="remember"
              v-model="form.remember"
              type="checkbox"
              class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
            />
            <label for="remember" class="ml-2 block text-sm text-gray-700">
              Recordarme
            </label>
          </div>
          <a href="#" class="text-sm text-blue-600 hover:text-blue-500 transition-colors duration-200">
            ¿Olvidaste tu contraseña?
          </a>
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          :disabled="loading"
          class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
        >
          <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          {{ loading ? 'Iniciando sesión...' : 'Iniciar Sesión' }}
        </button>
      </form>

      <!-- Success/Error Messages -->
      <div v-if="message" :class="[
        'p-4 rounded-lg text-sm',
        messageType === 'success' ? 'bg-green-50 text-green-800 border border-green-200' : 'bg-red-50 text-red-800 border border-red-200'
      ]">
        {{ message }}
      </div>

      <!-- Demo Credentials -->
      <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
        <h3 class="text-sm font-semibold text-gray-700 mb-2">Credenciales de prueba:</h3>
        <p class="text-xs text-gray-600">
          <strong>Email:</strong> admin@equilibra.com<br>
          <strong>Contraseña:</strong> admin123
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Login',
  data() {
    return {
      form: {
        email: '',
        password: '',
        remember: false
      },
      errors: {},
      loading: false,
      showPassword: false,
      logoLoaded: true,
      message: '',
      messageType: 'error'
    }
  },
  methods: {
    async handleLogin() {
      // Clear previous errors
      this.errors = {};
      this.message = '';
      
      // Basic validation
      if (!this.form.email) {
        this.errors.email = 'El correo electrónico es obligatorio';
        return;
      }
      
      if (!this.form.password) {
        this.errors.password = 'La contraseña es obligatoria';
        return;
      }
      
      this.loading = true;
      
      try {
        const response = await fetch('/api/auth/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
          },
          body: JSON.stringify({
            email: this.form.email,
            password: this.form.password,
            remember: this.form.remember
          })
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
          this.message = 'Inicio de sesión exitoso';
          this.messageType = 'success';
          
          // Store user data and token
          localStorage.setItem('user', JSON.stringify(data.user));
          localStorage.setItem('token', data.token);
          
          // Redirect to dashboard or emit event
          setTimeout(() => {
            this.$emit('login-success', data.user);
          }, 1000);
          
        } else {
          this.message = data.message || 'Error en el inicio de sesión';
          this.messageType = 'error';
          
          if (data.errors) {
            this.errors = data.errors;
          }
        }
        
      } catch (error) {
        console.error('Login error:', error);
        this.message = 'Error de conexión. Por favor, intenta de nuevo.';
        this.messageType = 'error';
      } finally {
        this.loading = false;
      }
    },

    showDefaultLogo() {
      this.logoLoaded = false;
    }
  }
}
</script>

<style scoped>
/* Animaciones adicionales */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>