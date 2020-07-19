import React, {useEffect, useState} from 'react';
import ReactDOM from 'react-dom';
import {Typeahead} from 'react-bootstrap-typeahead';

function VoterSelect({dataString, id}) {
    const [selectOptions, setSelectOptions] = useState([]);
    const [selected, setSelected] = useState([]);
    const [isLoading, setIsLoading] = useState(true);
    const [isInvalid, setIsInvalid] = useState(false);
    const [engSoc, setEngSoc] = useState({});

    useEffect(() => {
        let data = JSON.parse(dataString);
        setSelectOptions(data.options);
        setSelected(data.selected ? [data.selected] : []);
        setEngSoc(data.engSoc);
        setIsLoading(false);
    }, [dataString])

    function onSelectedChange(values) {
        if (values.length === 1 || values.length === 0) {
            setIsLoading(true);
            setIsInvalid(false);
            axios.put('/api/engsocs/' + engSoc.id, {
                voter_id: (values.length === 0 ? 0 : values[0].id)
            }).then((response) => {
                if (response.status !== 200) {
                    //TODO: Display errors to user.
                    setIsInvalid(true);
                } else {
                    console.log(response);
                }
            }).catch((error) => {
                //TODO: Display errors to user
                console.log(error);
                setIsInvalid(true);
            }).then(() => {
                setIsLoading(false);
            })
        }
        setSelected(values)
    }

    function onClear() {
        setSelected([]);
        onSelectedChange([]);
    }

    return (

        <div className="input-group mb-3">
            <Typeahead id={id}
                       labelKey={option => `${option.name}`}
                       filterBy={["name", 'email']}
                       defaultSelected={[]}
                       isLoading={isLoading}
                       isInvalid={isInvalid}
                       selected={selected}
                       options={selectOptions}
                       placeholder={'Select a voter...'}
                       onChange={onSelectedChange}
                       align={"left"}
            />
            <div className="input-group-append">
                <button className={"btn "+(selected.length ? 'btn-secondary' : 'btn-outline-secondary')} type="button" onClick={onClear}>Clear</button>
            </div>
        </div>

    )
}

let elements = document.getElementsByClassName('voter-select')
for (let i = 0; i < elements.length; i++) {
    let domObj = elements[i];
    let data = domObj.getAttribute('data');
    let id = domObj.getAttribute('id')
    ReactDOM.render(<VoterSelect id={id} dataString={data}/>, domObj);
}
