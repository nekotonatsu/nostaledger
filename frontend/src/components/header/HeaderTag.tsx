import { Link } from 'react-router-dom'

interface Props {
    headerMessage: string,
    to: string
}  

export default function HeaderTag({
    headerMessage,
    to,
} : Props) {
    return (
        <div className='flex-none w-18 ml-auto mr-auto'>
            <Link to={to} className="text-indigo-600 hover:underline">
                {headerMessage}
            </Link>
        </div>
    )
}