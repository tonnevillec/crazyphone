import React, {useEffect, useState} from 'react';
import fetchApi from "../services/fetchApi";

const SelectOption = ({id, name, label, handleChange, selectedValue, endpoint}) => {
    const [datas, setDatas] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetchDatas()
    }, [])

    const fetchDatas= async () => {
        const d = await fetchApi.get(endpoint);
        setDatas(d);

        setLoading(false)
    }

    return (
        <div className="form-control w-full">
            <label className="label" htmlFor={id}>
                <span className="label-text">{label}</span>
            </label>
            <select id={id}
                    name={name}
                    onChange={(e) => handleChange(e)}
                    value={selectedValue}
                    className="select select-bordered select-sm w-full">
                <option value=""></option>
                {!loading && datas.map(data => <option key={data.id} value={data.value}>{data.value}</option>)}
            </select>
        </div>
    );
};

export default SelectOption;