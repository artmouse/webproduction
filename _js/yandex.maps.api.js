function MultiGeocoder(options) {
    this._options = options || {};
}
MultiGeocoder.prototype.geocode = function (requests, options) {
    var self = this,
            size = requests.length,
            promise = new ymaps.util.Promise(),
            geoObjects = new ListCollection();
    requests.forEach(function (request, index) {
        ymaps.geocode(request, ymaps.util.extend({}, self._options, options))
                .then(
                        function (response) {
                            var geoObject = response.geoObjects.get(0);

                            geoObject && geoObjects.add(geoObject, index);
                            --size || promise.resolve({geoObjects: geoObjects});
                        },
                        function (err) {
                            promise.reject(err);
                        }
                );
    });

    return promise;
};
function ListCollection() {
    ListCollection.superclass.constructor.apply(this, arguments);
    this._list = [];
}

ymaps.ready(function () {
    ymaps.util.augment(ListCollection, ymaps.GeoObjectCollection, {
        get: function (index) {
            return this._list[index];
        },
        add: function (child, index) {
            this.constructor.superclass.add.call(this, child);

            index = index == null ? this._list.length : index;
            this._list[index] = child;

            return this;
        },
        indexOf: function (o) {
            for (var i = 0, len = this._list.length; i < len; i++) {
                if (this._list[i] === o) {
                    return i;
                }
            }

            return -1;
        },
        splice: function (index, number) {
            var added = Array.prototype.slice.call(arguments, 2),
                    removed = this._list.splice.apply(this._list, arguments);

            for (var i = 0, len = added.length; i < len; i++) {
                this.add(added[i]);
            }

            for (var i = 0, len = removed.length; i < len; i++) {
                this.remove(removed[i]);
            }

            return removed;
        },
        remove: function (child) {
            this.constructor.superclass.remove.call(this, child);

            // this._list.splice(this.indexOf(child), 1);
            delete this._list[this.indexOf(child)];

            return this;
        },
        removeAll: function () {
            this.constructor.superclass.removeAll.call(this);

            this._list = [];

            return this;
        },
        each: function (callback, context) {
            for (var i = 0, len = this._list.length; i < len; i++) {
                callback.call(context, this._list[i]);
            }
        }
    });
});

ymaps.ready(function (init) {
    var map = new ymaps.Map('map', {
        center: [51.20, 31.30],
        zoom: 6,
        behaviors: ['default', 'scrollZoom'],
    });
    
    var mGeocoder = new MultiGeocoder({boundedBy: map.getBounds()});
    map.controls.add('typeSelector', {position: {right: '10px', top: '50px'}});
    //map.controls.add('zoomControl', {position: {right: '10px', top: '200px'}});
    //map.controls.add('routeEditor', {position: {right: '280px', top: '50px'}});
    //map.controls.add('fullscreenControl', {position: {right: '10px', top: '50px'}});
    // Геокодирование массива адресов и координат.
    var data = JSON.parse($j('#contentJsonAddress').html());
    mGeocoder.geocode(data)
            .then(function (res) {
                // Асинхронно получаем коллекцию найденных геообъектов.
                map.geoObjects.add(res.geoObjects);
            },
                    function (err) {
                        console.log(err);
                    });
});