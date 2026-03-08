// E-sitrana Clinic JavaScript Application

class EstitranaApp {
    constructor() {
        this.apiBase = window.location.origin + '/api.php?endpoint=';
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.checkAuthStatus();
    }

    setupEventListeners() {
        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    }

    // API Helper Methods
    async apiCall(endpoint, options = {}) {
        const url = `${this.apiBase}${endpoint}`;
        console.log('API Call:', url); // Debug
        
        try {
            const response = await fetch(url, {
                headers: {
                    'Content-Type': 'application/json',
                    ...options.headers
                },
                ...options
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }

            const data = await response.json();
            console.log('API Response:', data); // Debug
            return data;
        } catch (error) {
            console.error('API Error:', error);
            this.showAlert(error.message, 'danger');
            throw error;
        }
    }

    // Alert System
    showAlert(message, type = 'success') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const container = document.querySelector('.container');
        if (container) {
            container.insertBefore(alertDiv, container.firstChild);
            
            // Auto-hide after 5 seconds
            setTimeout(() => {
                alertDiv.style.transition = 'opacity 0.5s';
                alertDiv.style.opacity = '0';
                setTimeout(() => alertDiv.remove(), 500);
            }, 5000);
        }
    }

    // Loading States
    showLoading(element) {
        if (typeof element === 'string') {
            element = document.querySelector(element);
        }
        if (element) {
            element.disabled = true;
            element.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Chargement...';
        }
    }

    hideLoading(element, originalText) {
        if (typeof element === 'string') {
            element = document.querySelector(element);
        }
        if (element) {
            element.disabled = false;
            element.innerHTML = originalText;
        }
    }

    // Authentication
    async checkAuthStatus() {
        try {
            const result = await this.apiCall('auth');
            return result.admin;
        } catch (error) {
            return null;
        }
    }

    async login(username, password) {
        return await this.apiCall('auth', {
            method: 'POST',
            body: JSON.stringify({ username, password })
        });
    }

    async logout() {
        return await this.apiCall('auth', { method: 'DELETE' });
    }

    // Services
    async getServices() {
        const result = await this.apiCall('services');
        return result.records || [];
    }

    async createService(serviceData) {
        return await this.apiCall('services', {
            method: 'POST',
            body: JSON.stringify(serviceData)
        });
    }

    async updateService(id, serviceData) {
        return await this.apiCall(`services?id=${id}`, {
            method: 'PUT',
            body: JSON.stringify(serviceData)
        });
    }

    async deleteService(id) {
        return await this.apiCall(`services?id=${id}`, { method: 'DELETE' });
    }

    // Doctors
    async getDoctors(serviceId = null) {
        const endpoint = serviceId ? `doctors&service_id=${serviceId}` : 'doctors';
        const result = await this.apiCall(endpoint);
        return result.records || [];
    }

    async createDoctor(doctorData) {
        return await this.apiCall('doctors', {
            method: 'POST',
            body: JSON.stringify(doctorData)
        });
    }

    async updateDoctor(id, doctorData) {
        return await this.apiCall(`doctors?id=${id}`, {
            method: 'PUT',
            body: JSON.stringify(doctorData)
        });
    }

    async deleteDoctor(id) {
        return await this.apiCall(`doctors?id=${id}`, { method: 'DELETE' });
    }

    // Appointments
    async getAppointments() {
        const result = await this.apiCall('appointments');
        return result.records || [];
    }

    async createAppointment(appointmentData) {
        return await this.apiCall('appointments', {
            method: 'POST',
            body: JSON.stringify(appointmentData)
        });
    }

    async updateAppointment(id, appointmentData) {
        return await this.apiCall(`appointments?id=${id}`, {
            method: 'PUT',
            body: JSON.stringify(appointmentData)
        });
    }

    async deleteAppointment(id) {
        return await this.apiCall(`appointments?id=${id}`, { method: 'DELETE' });
    }

    // Dashboard
    async getDashboardStats() {
        return await this.apiCall('dashboard');
    }

    // Patients
    async getPatients() {
        const result = await this.apiCall('patients');
        return result.records || [];
    }

    async createPatient(patientData) {
        return await this.apiCall('patients', {
            method: 'POST',
            body: JSON.stringify(patientData)
        });
    }

    async updatePatient(id, patientData) {
        return await this.apiCall(`patients?id=${id}`, {
            method: 'PUT',
            body: JSON.stringify(patientData)
        });
    }

    async deletePatient(id) {
        return await this.apiCall(`patients?id=${id}`, { method: 'DELETE' });
    }

    // Form Validation
    validateForm(formElement) {
        const inputs = formElement.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;

        inputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }

            // Email validation
            if (input.type === 'email' && input.value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(input.value)) {
                    input.classList.add('is-invalid');
                    isValid = false;
                }
            }

            // Phone validation
            if (input.name === 'phone' && input.value) {
                const phoneRegex = /^[\d\s\+\-\(\)]+$/;
                if (!phoneRegex.test(input.value)) {
                    input.classList.add('is-invalid');
                    isValid = false;
                }
            }
        });

        return isValid;
    }

    // Date Formatting
    formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('fr-FR', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    formatTime(timeString) {
        return timeString.substring(0, 5);
    }

    // Utility Functions
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Modal Management
    showModal(modalId) {
        const modal = new bootstrap.Modal(document.getElementById(modalId));
        modal.show();
        return modal;
    }

    hideModal(modalId) {
        const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
        if (modal) {
            modal.hide();
        }
    }

    // Table Management
    populateTable(tableBody, data, columns, actions = null) {
        tableBody.innerHTML = '';
        
        if (data.length === 0) {
            const row = tableBody.insertRow();
            const cell = row.insertCell();
            cell.colSpan = columns.length + (actions ? 1 : 0);
            cell.className = 'text-center text-muted py-4';
            cell.textContent = 'Aucune donnée disponible';
            return;
        }

        data.forEach(item => {
            const row = tableBody.insertRow();
            
            columns.forEach(column => {
                const cell = row.insertCell();
                if (typeof column === 'function') {
                    cell.innerHTML = column(item);
                } else {
                    cell.textContent = item[column] || '-';
                }
            });

            if (actions) {
                const actionsCell = row.insertCell();
                actionsCell.innerHTML = actions(item);
            }
        });
    }

    // Service Icons
    getServiceIcon(iconName) {
        const icons = {
            'fa-user-md': '<i class="fas fa-user-md"></i>',
            'fa-child': '<i class="fas fa-child"></i>',
            'fa-female': '<i class="fas fa-female"></i>',
            'fa-heartbeat': '<i class="fas fa-heartbeat"></i>',
            'fa-flask': '<i class="fas fa-flask"></i>'
        };
        return icons[iconName] || '<i class="fas fa-hospital"></i>';
    }

    // Status Badges
    getStatusBadge(status) {
        const badges = {
            'en attente': '<span class="badge badge-warning">En attente</span>',
            'confirmé': '<span class="badge badge-success">Confirmé</span>',
            'annulé': '<span class="badge badge-danger">Annulé</span>',
            'terminé': '<span class="badge badge-secondary">Terminé</span>'
        };
        return badges[status] || '<span class="badge badge-secondary">Inconnu</span>';
    }
}

// Initialize the app
const app = new EstitranaApp();

// Export for use in other scripts
window.EstitranaApp = EstitranaApp;
window.app = app;
