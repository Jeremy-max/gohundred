"use strict";

var graph_demo = function(){
    var graph = function () {
        var keyword = $('#table_keyword').val();
        graph.colors = [
            "#007bff",
            "#00aced",
            "#ffb822",
            "#fd397a",
            "#0abb87"
        ]

        $.get('/graph', {'keyword': keyword}).done(function(response){
            new Morris.Line({
                element: "campaign_graph",
                data: response,
                xkey: "y",
                ykeys: ["f", "t", "i", "u", "w"],
                labels: ["Facebook", "Twitter", "Instagram", "Youtube", "Web"],
                lineColors: graph.colors
            })
        });

        
    }
    
    return {
        init: function(){
            graph();
        } 
    };
}();


jQuery(document).ready(function() {
    graph_demo.init();
});