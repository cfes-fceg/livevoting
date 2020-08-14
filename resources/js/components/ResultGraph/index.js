import {HorizontalGridLines, VerticalBarSeries, VerticalGridLines, XAxis, XYPlot, YAxis} from 'react-vis';
import React, {useEffect, useState} from "react";
import ReactDOM from 'react-dom';

export function ResultGraph({data, className, height, width}) {
    const [graphData, setGraphData] = useState([]);

    useEffect(() => {
        if (data)
            setGraphData([
                {x: "For", y: data.FOR, color: "var(--green)"},
                {x: "Against", y: data.AGAINST, color: "var(--red)"},
                {x: "Abstain", y: data.ABSTAIN, color: "var(--yellow)"}
            ]);
    }, [data])

    if (graphData && graphData.length > 0)
        return (
            <XYPlot className="mx-auto" height={height} width={width} xDistance={100} xType="ordinal">
                <HorizontalGridLines />
                <XAxis style={{
                    fontSize: "0.95em"
                }}/>
                <YAxis style={{
                    fontSize: "0.95em"
                }}/>
                <VerticalBarSeries colorType={"literal"} data={graphData}/>
            </XYPlot>
        )
    else
        return (
            <div style={{"height": height, "width": width}}>
                <div className="mx-auto my-auto">
                    Loading...
                </div>
            </div>
        )
}


let elements = document.getElementsByClassName('results-graph')
for (let i = 0; i < elements.length; i++) {
    let domObj = elements[i];
    let data = domObj.getAttribute('data');
    let height = domObj.getAttribute('height');
    let width = domObj.getAttribute('width');
    domObj.setAttribute('data', null)
    let classes = domObj.getAttribute('class');
    ReactDOM.render(<ResultGraph data={JSON.parse(data)} height={250} width={250} className={classes}/>, domObj);
}
