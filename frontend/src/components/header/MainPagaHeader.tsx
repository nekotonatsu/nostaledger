import HeaderTag from './HeaderTag'
import AppName from './AppName'

export default function AllPageHeader() {
    return (
        <div className="flex items-center w-full">
            <div className="flex gap-4 flex-wrap">
                <HeaderTag
                    headerMessage = '確定支出追加・削除'
                    to = "/login"
                />
                <HeaderTag
                    headerMessage = '支出追加・削除'
                    to = "/login"
                />
                <HeaderTag
                    headerMessage = 'タグ追加・削除'
                    to = "/login"
                />
                <HeaderTag
                    headerMessage = '必須出資タグ追加・削除'
                    to = "/login"
                />
            </div>
            <div className="ml-auto shrink-0 pl-4">
                <AppName/>
            </div>
        </div>
    )
}