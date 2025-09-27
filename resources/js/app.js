import './bootstrap';
import { createApp } from 'vue'
import Login from './components/Login.vue'

const app = createApp({
    components: {
        Login
    },
    data() {
        return {
            isAuthenticated: false,
            currentUser: null
        }
    },
    mounted() {
        
        const token = localStorage.getItem('auth_token');
        const userData = localStorage.getItem('user_data');
        
        if (token && userData) {
            this.isAuthenticated = true;
            this.currentUser = JSON.parse(userData);
        }
    },
    methods: {
        onLoginSuccess(userData) {
            this.isAuthenticated = true;
            this.currentUser = userData;
        },
        
        logout() {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user_data');
            this.isAuthenticated = false;
            this.currentUser = null;
        }
    },
    template: `
        <div>
            
            <Login 
                v-if="!isAuthenticated" 
                @login-success="onLoginSuccess"
            />

            <div v-else class="min-h-screen bg-gray-100">
                <header class="bg-white shadow-sm border-b">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-center py-4">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">EquilibraAPP</h1>
                                <p class="text-sm text-gray-600">Bienvenido, {{ currentUser.nombre }} {{ currentUser.apellido }}</p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                    {{ currentUser.rol_nombre }}
                                </span>
                                <button 
                                    @click="logout"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition-colors"
                                >
                                    Cerrar Sesión
                                </button>
                            </div>
                        </div>
                    </div>
                </header>
                
                <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold mb-4">Dashboard</h2>
                        <p class="text-gray-600">Sistema de gestión psicológica en desarrollo...</p>
                        
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h3 class="font-semibold text-blue-900">Usuarios</h3>
                                <p class="text-blue-700">Gestionar usuarios del sistema</p>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <h3 class="font-semibold text-green-900">Pacientes</h3>
                                <p class="text-green-700">Administrar información de pacientes</p>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-lg">
                                <h3 class="font-semibold text-purple-900">Citas</h3>
                                <p class="text-purple-700">Programar y gestionar citas</p>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    `
})

app.mount('#app')
