/**
 * Sistema de Firma Digital
 * Permite dibujar y cargar firmas para psicólogos
 */

class FirmaDigital {
    constructor(canvasId, containerId) {
        this.canvas = document.getElementById(canvasId);
        this.container = document.getElementById(containerId);
        this.ctx = this.canvas.getContext('2d');
        this.isDrawing = false;
        this.lastX = 0;
        this.lastY = 0;
        this.firmaSaved = false;
        
        this.initCanvas();
        this.bindEvents();
    }
    
    initCanvas() {
        
        this.canvas.width = 400;
        this.canvas.height = 200;

        this.ctx.strokeStyle = '#000000';
        this.ctx.lineWidth = 2;
        this.ctx.lineCap = 'round';
        this.ctx.lineJoin = 'round';

        this.ctx.fillStyle = '#ffffff';
        this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
    }
    
    bindEvents() {
        
        this.canvas.addEventListener('mousedown', (e) => this.startDrawing(e));
        this.canvas.addEventListener('mousemove', (e) => this.draw(e));
        this.canvas.addEventListener('mouseup', () => this.stopDrawing());
        this.canvas.addEventListener('mouseout', () => this.stopDrawing());

        this.canvas.addEventListener('touchstart', (e) => {
            e.preventDefault();
            const touch = e.touches[0];
            const mouseEvent = new MouseEvent('mousedown', {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            this.canvas.dispatchEvent(mouseEvent);
        });
        
        this.canvas.addEventListener('touchmove', (e) => {
            e.preventDefault();
            const touch = e.touches[0];
            const mouseEvent = new MouseEvent('mousemove', {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            this.canvas.dispatchEvent(mouseEvent);
        });
        
        this.canvas.addEventListener('touchend', (e) => {
            e.preventDefault();
            const mouseEvent = new MouseEvent('mouseup', {});
            this.canvas.dispatchEvent(mouseEvent);
        });
    }
    
    startDrawing(e) {
        this.isDrawing = true;
        const rect = this.canvas.getBoundingClientRect();
        this.lastX = e.clientX - rect.left;
        this.lastY = e.clientY - rect.top;
    }
    
    draw(e) {
        if (!this.isDrawing) return;
        
        const rect = this.canvas.getBoundingClientRect();
        const currentX = e.clientX - rect.left;
        const currentY = e.clientY - rect.top;
        
        this.ctx.beginPath();
        this.ctx.moveTo(this.lastX, this.lastY);
        this.ctx.lineTo(currentX, currentY);
        this.ctx.stroke();
        
        this.lastX = currentX;
        this.lastY = currentY;
    }
    
    stopDrawing() {
        this.isDrawing = false;
    }
    
    limpiarCanvas() {
        this.ctx.fillStyle = '#ffffff';
        this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
        this.firmaSaved = false;
    }
    
    cambiarGrosor(grosor) {
        this.ctx.lineWidth = grosor;
    }
    
    obtenerImagenBase64() {
        return this.canvas.toDataURL('image/png');
    }
    
    async guardarFirma(usuarioId) {
        const firmaData = this.obtenerImagenBase64();
        
        try {
            const response = await fetch('/firmas/guardar-dibujada', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    firma_data: firmaData,
                    usuario_id: usuarioId
                })
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.firmaSaved = true;
                return result;
            } else {
                throw new Error(result.error || 'Error al guardar firma');
            }
            
        } catch (error) {
            console.error('Error guardando firma:', error);
            throw error;
        }
    }
    
    estaVacio() {
        const imageData = this.ctx.getImageData(0, 0, this.canvas.width, this.canvas.height);
        const pixels = imageData.data;
        
        for (let i = 0; i < pixels.length; i += 4) {
            
            if (pixels[i] !== 255 || pixels[i + 1] !== 255 || pixels[i + 2] !== 255) {
                return false;
            }
        }
        return true;
    }
}

window.FirmaDigital = FirmaDigital;

window.inicializarFirmaDigital = function(canvasId = 'firma-canvas', containerId = 'firma-container') {
    if (document.getElementById(canvasId)) {
        return new FirmaDigital(canvasId, containerId);
    }
    return null;
};

window.subirArchivoFirma = async function(archivo, usuarioId) {
    const formData = new FormData();
    formData.append('firma_archivo', archivo);
    formData.append('usuario_id', usuarioId);
    
    try {
        const response = await fetch('/firmas/guardar-subida', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            return result;
        } else {
            throw new Error(result.error || 'Error al subir firma');
        }
        
    } catch (error) {
        console.error('Error subiendo firma:', error);
        throw error;
    }
};

window.mostrarPreviewFirma = function(rutaArchivo, containerId = 'firma-preview') {
    const container = document.getElementById(containerId);
    if (container) {
        container.innerHTML = `
            <div class="firma-preview-container">
                <img src="/${rutaArchivo}" alt="Firma digital" style="max-width: 200px; max-height: 100px; border: 1px solid #ddd; border-radius: 5px;">
                <button type="button" class="btn btn-sm btn-danger ms-2" onclick="eliminarFirmaPreview('${containerId}')">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
    }
};

window.eliminarFirmaPreview = function(containerId) {
    const container = document.getElementById(containerId);
    if (container) {
        container.innerHTML = '';
    }
};