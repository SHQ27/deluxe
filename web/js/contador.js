var Contador = {
    
    INTERVAL_MS: 1000,
    TEXTO: {
        1: "Día",
        _default: "Días"
    },
        
    interval: null,
    contadores: [],
    
    _class: function (diasEl, horasEl) {   
        this.dias = 0;
        this.seconds = 0,
        this.el = {
            dias: null,
            horas: null,
            texto: null
        };
                
        this.el.dias = $(diasEl);
        this.el.horas = $(horasEl);
                
        this.dias = parseInt(this.el.dias.attr('rel'));
        this._static = Contador;
        this.seconds = this._static.hourToSeconds(this.el.horas.html());
        
        this.update = function () {
            this.seconds--;
            if (this.seconds < 0) {
                this.seconds = this._static.hourToSeconds('23:59:59');
                this.dias--;
                
                var texto = typeof(this._static.TEXTO[this.dias]) != 'undefined' ? 
                        this._static.TEXTO[this.dias]:
                        this._static.TEXTO._default;
                        console.log/texto();
                        this.el.dias.html(this.dias + ' ' + texto);
                        this.el.dias.attr('rel', this.dias);
            }
            var hour = this._static.secondsToHours(this.seconds);
            this.el.horas.html(hour);
        };
    },
    
    setUp: function (diasEl, horasEl) {
        var self = this;
        $(diasEl).each(function (i) {
            self.contadores[i] = new self._class(this, $(horasEl)[i]); 
        })
        this.interval = setInterval(function () { self.update(); }, this.INTERVAL_MS);
    },
    
    hourToSeconds: function (hour) {
        var tmp = hour.split(":");
        var hours = parseInt(tmp[0]);
        var minutes = parseInt(tmp[1]);
        var seconds = parseInt(tmp[2]);
        return hours * 60 * 60 + minutes * 60 + seconds; 
    },
    
    secondsToHours: function (seconds) {
        var hours = Math.floor(seconds / 60 / 60);
        seconds = seconds - hours * 60 * 60;
        var minutes = Math.floor(seconds / 60);
        seconds = seconds - minutes * 60;
        if (minutes < 10) {
            minutes = "0" + minutes;
        }
        if (seconds < 10) {
            seconds = "0" + seconds;
        }

        return hours + ":" + minutes + ":" + seconds;
    },

    update: function () {
        for (var i = 0; i < this.contadores.length; i++) {
            this.contadores[i].update();
        }
    }
    
}

$(function () {
    Contador.setUp(".contador_dias", ".contador_horas");
})